<?php

namespace Swiftqueue\Controllers;

use PDOException;
use Swiftqueue\Core\Controller\AbstractController;

/**
 * Class CoursesController
 *
 * @package Swiftqueue\Controllers
 */
class CoursesController extends AbstractController
{

    /**
     * CoursesController constructor.
     *
     * @param $db PDO database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
    }

    /**
     * List all courses
     * 
     * @return string json all courses
     */
    public function list_courses()
    {
        try {
            $status  = $this->request->get('status');
            $sort    = $this->request->get('sort');
            $search  = $this->request->get('search');
            $courses = $this->course->get_all_courses($status, $sort,$search);

            echo json_encode($courses);
        } catch (PDOException $e) {
            http_response_code(500);
            // print_r($e->getMessage());

            echo json_encode(['message' => 'Something went wrong. Please contact support.']);
        }
    }

    /**
     * Get a course by id
     *
     * @param $id int course id
     * 
     * @return string json course data
     */
    public function get_course($id)
    {
        try {
            $course = $this->course->get_course($id);
            echo json_encode($course);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Something went wrong. Please contact support.']);
        }
    }

    /**
     * Create a course
     * 
     * @return string json success or failure
     */
    public function create_course()
    {
        $name = $this->request->get('name');
        $start_date = $this->request->get('start_date');
        $end_date = $this->request->get('end_date');
        $status = $this->request->get('status');

        $result = $this->course->add_course($name, $start_date, $end_date, $status);

        if ($result) {
            echo json_encode(['message' => 'Course added successfully.']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Failed to add course.']);
        }
    }

    /**
     * Delete a course
     * 
     * @return string json success or failure
     */
    public function delete_course()
    {
        $id = $this->request->get('id');

        $result = $this->course->delete_course($id);

        if ($result) {
            echo json_encode(['message' => "Course $id deleted successfully."]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Failed to delete course.']);
        }
    }

    /**
     * Update a course
     * 
     * @return string json success or failure
     */
    public function update_course()
    {
        $id = $this->request->get('id');
        $name = $this->request->get('name');
        $start_date = $this->request->get('start_date');
        $end_date = $this->request->get('end_date');
        $status = $this->request->get('status');

        $result = $this->course->update_course($id, $name, $start_date, $end_date, $status);

        if ($result) {
            echo json_encode(['message' => "Course $id updated successfully."]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Failed to update course.']);
        }
    }
}
