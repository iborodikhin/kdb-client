<?php
namespace Kdb;

/**
 * Connection to KDB.
 */
class Connection
{
    /**
     * Response success status.
     */
    const STATUS_OK = 200;

    /**
     * KDB host address.
     *
     * @var string
     */
    protected $host;

    /**
     * KDB port number.
     *
     * @var integer
     */
    protected $port;

    /**
     * Curl connection.
     *
     * @var resource
     */
    protected $client;

    /**
     * Public constructor.
     *
     * @param string  $host
     * @param integer $port
     */
    public function __construct($host = '127.0.0.1', $port = 1337)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Read file from KDB.
     *
     * @param  string    $remoteFile
     * @return \Kdb\File
     */
    public function get($remoteFile)
    {
        $result = $this->getClient()->get($this->getUrlForFilename($remoteFile));

        $file = new File();
        $file->setContent($result->getBody())
            ->setName(basename($remoteFile))
            ->setMimeType($result->getHeader('Content-Type'));

        return $file;
    }

    /**
     * Upload file to KDB.
     *
     * @param  \Kdb\File $localFile
     * @param  string    $remoteFile
     * @return boolean
     */
    public function save(File $localFile, $remoteFile)
    {
        $result = $this->getClient()->post(
            $this->getUrlForFilename($remoteFile),
            [
                'body' => $localFile->getContent(),
            ]
        );

        return $result->getStatusCode() == self::STATUS_OK;
    }

    /**
     * Remove file from KDB.
     *
     * @param  string  $remoteFile
     * @return boolean
     */
    public function remove($remoteFile)
    {
        $result = $this->getClient()->delete($this->getUrlForFilename($remoteFile));

        return $result->getStatusCode() == self::STATUS_OK;
    }

    /**
     * Check if file exists in KDB.
     *
     * @param  string  $remoteFile
     * @return boolean
     */
    public function exists($remoteFile)
    {
        $result = $this->getClient()->head($this->getUrlForFilename($remoteFile));

        return $result->getStatusCode() == self::STATUS_OK;
    }

    /**
     * Get CURL resource.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        if (null === $this->client) {
            $this->client = new \GuzzleHttp\Client();
        }

        return $this->client;
    }

    /**
     * Get remote file url.
     *
     * @param  string $remoteFile
     * @return string
     */
    protected function getUrlForFilename($remoteFile)
    {
        return sprintf(
            'http://%s:%d%s',
            $this->host,
            $this->port,
            (substr($remoteFile, 0, 1) != '/' ? '/' . $remoteFile : $remoteFile)
        );
    }
}
