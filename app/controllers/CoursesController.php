<?php

namespace Swiftqueue\Controllers;

use PDOException;
use Swiftqueue\Core\Controller\AbstractController;

/**
 * Class CoursesController
 * @package Swiftqueue\Controllers
 */
class CoursesController extends AbstractController
{

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function list_courses()
    {
        try {
            $courses = $this->course->get_all_courses();
            echo json_encode($courses);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Something went wrong. Please contact support.']);
        }
    }

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
