<?php
namespace Kdb;

/**
 * KDB Client.
 */
class Client
{
    /**
     * KDB host address.
     *
     * @var string
     */
    protected $host;

    /**
     * KDB port number;
     *
     * @var integer
     */
    protected $port;

    /**
     * KDB connection.
     *
     * @var \Kdb\Connection
     */
    protected $connection;

    /**
     * Public constructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        if (!is_array($options)) {
            $options = [];
        }

        $options = array_merge([
            'host' => '127.0.0.1',
            'port' => 1337,
        ], $options);

        $this->host = $options['host'];
        $this->port = $options['port'];
    }

    /**
     * Reads file from KDB.
     *
     * @param  string    $remoteFile
     * @return \Kdb\File
     */
    public function get($remoteFile)
    {
        return $this->getConnection()->get($remoteFile);
    }

    /**
     * Uploads local file to KDB.
     *
     * @param  string  $localFile
     * @param  string  $remoteFile
     * @return boolean
     */
    public function save($localFile, $remoteFile)
    {
        return $this->getConnection()->save(
            (new File())->loadFromFilesystem($localFile),
            $remoteFile
        );
    }

    /**
     * Removed file from KDB.
     *
     * @param  string  $remoteFile
     * @return boolean
     */
    public function remove($remoteFile)
    {
        return $this->getConnection()->remove($remoteFile);
    }

    /**
     * Checks if file exists in KDB.
     *
     * @param  string  $remoteFile
     * @return boolean
     */
    public function exists($remoteFile)
    {
        return $this->getConnection()->exists($remoteFile);
    }

    /**
     * Get KDB connection.
     *
     * @return \Kdb\Connection
     */
    protected function getConnection()
    {
        if ($this->connection === null) {
            $this->connection = new Connection($this->host, $this->port);
        }

        return $this->connection;
    }
}