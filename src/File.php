<?php
namespace Kdb;

/**
 * File object.
 */
class File
{
    /**
     * File name.
     *
     * @var string
     */
    protected $name;

    /**
     * File type.
     *
     * @var string
     */
    protected $mimeType;

    /**
     * File content.
     *
     * @var string
     */
    protected $content;

    /**
     * Get file name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set file name.
     *
     * @param  string    $name
     * @return \Kdb\File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get file type.
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set file type.
     *
     * @param  string    $mimeType
     * @return \Kdb\File
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get file content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set file content.
     *
     * @param  string    $content
     * @return \Kdb\File
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Loads data from filesystem.
     *
     * @param  string    $filename
     * @return \Kdb\File
     */
    public function loadFromFilesystem($filename)
    {
        $info = finfo_open();
        $type = finfo_file($info, $filename, FILEINFO_MIME_TYPE);

        $this->setName($filename)
            ->setContent(file_get_contents($filename))
            ->setMimeType($type);

        return $this;
    }
}
