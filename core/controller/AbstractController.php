<?php

namespace Swiftqueue\Core\Controller;

use Swiftqueue\Core\Http\Request;
use Swiftqueue\Models\Course;

/**
 * Class AbstractController
 *
 * @package Swiftqueue\Core\Controller
 */
abstract class AbstractController
{
    protected $db;
    protected $request;
    protected $course;

    public function __construct($db)
    {
        $this->db = $db;
        $this->request = new Request();
        $this->course = new Course($db);
    }

    public function list_courses()
    {
    }

    public function create_courses()
    {
    }

    public function delete_course()
    {
    }

    public function update_Course()
    {
    }
}
