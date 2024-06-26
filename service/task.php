<?php

declare(strict_types=1);
include("../model/task.php");
include("../model/response.php");
include("../config/pdo.php");

class TaskService
{
  private PDO $conn;

  public function __construct(PdoDao $pdo = new PdoDao())
  {
    $this->conn = $pdo->get_pdo();
  }

  public function get_tasks()
  {
    try {
      $sql = "SELECT * FROM task t order by status desc , created_at";

      $statement = $this->conn->prepare($sql);
      $statement->execute();
      $result =  $statement->fetchAll(PDO::FETCH_ASSOC);

      $tasks = [];
      if (!empty($result)) {
        foreach ($result as $row) {
          $task = new Task(
            $row['task_id'],
            $row['task_name'],
            $row['task_description'],
            $row['user_email'],
            $row['category'],
            $row['status'],
            $row['team'],
            $row['start_date'],
            $row['due_date'],
            $row['created_at'],
            $row['updated_at']
          );
          array_push($tasks, $task);
        }
        return $tasks;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  public function get_tasks_by_user(string $email)
  {
    try {
      $sql = "SELECT * FROM task t 
             WHERE user_email = :user_email 
             ORDER BY status DESC, created_at;
             ";

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':user_email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

      $tasks = [];
      if (!empty($result)) {
        foreach ($result as $row) {
          $task = new Task(
            $row['task_id'],
            $row['task_name'],
            $row['task_description'],
            $row['user_email'],
            $row['category'],
            $row['status'],
            $row['team'],
            $row['start_date'],
            $row['due_date'],
            $row['created_at'],
            $row['updated_at']
          );
          array_push($tasks, $task);
        }
        return $tasks;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
  public function get_task_by_id(int $task_id): Task
  {
    $sql = " SELECT 
      * FROM task
      WHERE task_id = :task_id
      AND
      deleted IS FALSE
      ;
    ";
    try {

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
      $stmt->execute();
      $result =  $stmt->fetch(PDO::FETCH_ASSOC);
      if (!empty($result)) {
        if ($result['start_date'] == null) {
          $result['start_date'] = "";
        }
        if ($result['due_date'] == null) {
          $result['due_date'] = "";
        }
        if ($result['updated_at'] == null) {
          $result['updated_at'] = "";
        }

        return new Task(
          $result['task_id'],
          $result['task_name'],
          $result['task_description'],
          $result['user_email'],
          $result['category'],
          $result['status'],
          $result['team'],
          $result['start_date'],
          $result['due_date'],
          $result['created_at'],
          $result['updated_at']
        );
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  function create_task(Task $task)
  {
    $task_name = $task->get_task_name();
    $task_description = $task->get_task_description();
    $user_email = $task->get_user_email();
    $category = $task->get_category();
    $status = $task->get_status();
    $team = $task->get_team();
    $start_date = $task->get_start_date();
    $due_date = $task->get_due_date();
    try {
      $sql = " INSERT INTO task 
      (task_name, task_description, user_email, category, status, team, start_date, due_date)
      VALUES
      (:task_name, :task_description, :user_email, :category, :status, :team, :start_date, :due_date)
      ";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':task_name', $task_name, PDO::PARAM_STR);
      $stmt->bindParam(':task_description', $task_description, PDO::PARAM_STR);
      $stmt->bindParam(':user_email', $task->$user_email, PDO::PARAM_STR);
      $stmt->bindParam(':category', $task->$category, PDO::PARAM_STR);
      $stmt->bindParam(':status', $task->$status, PDO::PARAM_STR);
      $stmt->bindParam(':team', $task->$team, PDO::PARAM_STR);
      $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
      $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
      $stmt->bindParam(':due_date', $task->get_due_date(), PDO::PARAM_STR);
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  function update_status(int $task_id, string $status)
  {
    try {
      $sql = " UPDATE task SET
      status = :status
      WHERE task_id = :task_id;
      ";

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  function update_task(Task $task)
  {
    $task_id = $task->get_task_id();
    $task_name = $task->get_task_name();
    $task_description = $task->get_task_description();
    $user_email = $task->get_user_email();
    $category = $task->get_category();
    $status = $task->get_status();
    $team = $task->get_team();
    $start_date = $task->get_start_date();
    $due_date = $task->get_due_date();

    try {
      $sql = " UPDATE task SET
      task_name = :task_name,
      task_description = :task_description,
      user_email = :user_email,
      status = :status,
      category= :category,
      team= :team,
      start_date = :start_date,
      due_date = :due_date
      WHERE task_id = :task_id;
      ";

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
      $stmt->bindParam(':task_name', $task_name, PDO::PARAM_STR);
      $stmt->bindParam(':task_description', $task_description, PDO::PARAM_STR);
      $stmt->bindParam(':user_email', $task->$user_email, PDO::PARAM_STR);
      $stmt->bindParam(':category', $task->$category, PDO::PARAM_STR);
      $stmt->bindParam(':status', $task->$status, PDO::PARAM_STR);
      $stmt->bindParam(':team', $task->$team, PDO::PARAM_STR);
      $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
      $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);

      if ($stmt->execute()) {
        return new Response(true, "Task updated successfully");
      } else {
        return new Response(false, "Task update failed");
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  function delete_task(int $task_id)
  {
    try {
      $sql = "UPDATE task SET
      deleted = TRUE
      WHERE task_id = :task_id;
      ";

      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
