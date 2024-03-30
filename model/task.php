<?php
class Task
{
  public ?int $task_id;
  public string $task_name;
  public string $task_description;
  public string $user_email;
  public ?string $category;
  public string $status;
  public ?string $team;
  public ?string $created_at;
  public ?string $updated_at;
  public ?string $start_date;
  public ?string $due_date;

  function __construct(?int $task_id, string $task_name, string $task_description, string $user_email, ?string $category, string $status,  ?string $team, ?string $start_date, ?string $due_date, ?string $created_at = null, ?string $updated_at = null)
  {
    $this->task_id = $task_id;
    $this->task_name = $task_name;
    $this->task_description = $task_description;
    $this->user_email = $user_email;
    $this->status = $status;
    $this->category = $category;
    $this->team = $team;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->start_date = $start_date;
    $this->due_date = $due_date;
  }

  public function get_task_id(): int
  {
    return $this->task_id;
  }
  public function get_task_name(): string
  {
    return $this->task_name;
  }
  public function get_task_description(): string
  {
    return $this->task_description;
  }
  public function get_user_email(): string
  {
    return $this->user_email;
  }
  public function get_team(): string | null
  {
    return $this->team;
  }
  public function get_status(): string
  {
    return $this->status;
  }
  public function get_category(): string | null
  {
    return $this->category;
  }
  public function get_created_at(): string
  {
    return $this->created_at;
  }
  public function get_updated_at(): string | null
  {
    return $this->updated_at;
  }
  public function get_start_date(): string | null
  {
    return $this->start_date;
  }
  public function get_due_date(): string | null
  {
    return $this->due_date;
  }
}

class TaskMM
{
  public ?int  $task_id;
  public string $task_name;
  public string $task_description;
  public int $status_id;
  public int $user_id;
  public int $team_id;
  public int $category_id;
  public ?string $start_date;
  public ?string $due_date;
  public function __construct(?int  $task_id, string $task_name, string $task_description, int $status_id, int $user_id, int $team_id, int $category_id, ?string $start_date = null, ?string $due_date = null)
  {
    $this->task_id = $task_id;
    $this->task_name = $task_name;
    $this->task_description = $task_description;
    $this->status_id = $status_id;
    $this->user_id = $user_id;
    $this->team_id = $team_id;
    $this->category_id = $category_id;
    $this->start_date = $start_date;
    $this->due_date = $due_date;
  }
}
