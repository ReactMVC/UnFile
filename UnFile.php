<?php

/*
Class UnFile
By Hossein Pira
Email: h3dev.pira@gmail.com
Telegram: @h3dev
Phone: +98 9039484577
*/

class UnFile
{
    private $url;
    private $path;

    public function __construct($url, $path)
    {
        $this->url = $url;
        $this->path = $path;
    }

    public function download()
    {
        // Determine which download method to use based on what's available
        if ($this->useCurl()) {
            $result = $this->downloadWithCurl();
        } elseif ($this->useCopy()) {
            $result = $this->downloadWithCopy();
        } else {
            $result = $this->downloadWithResponse();
        }

        // Print a message indicating whether the download was successful or not
        if ($result) {
            echo 'File downloaded successfully from ' . $this->url . ' to ' . $this->path . PHP_EOL;
        } else {
            echo 'Error downloading file from ' . $this->url . PHP_EOL;
        }
    }

    private function useCurl()
    {
        // Check if the curl extension is available
        return function_exists('curl_version');
    }

    private function useCopy()
    {
        // Check if the copy function is available
        return function_exists('copy');
    }

    private function downloadWithCurl()
    {
        // Download the file using the curl extension
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        // Handle any errors that occurred during the download
        if ($error) {
            return false;
        }

        // Save the downloaded data to a file and return whether it was successful
        return file_put_contents($this->path, $data) !== false;
    }

    private function downloadWithCopy()
    {
        // Download the file using the copy function
        $result = copy($this->url, $this->path);

        // Return whether the download was successful
        return $result;
    }

    private function downloadWithResponse()
    {
        // Download the file using the file_get_contents function
        $data = file_get_contents($this->url);

        // Handle any errors that occurred during the download
        if ($data === false) {
            return false;
        }

        // Save the downloaded data to a file and return whether it was successful
        return file_put_contents($this->path, $data) !== false;
    }
}