<?php

abstract class BaseController
{
    protected $model;
    protected $viewPath;

    public function __construct($model, $viewPath)
    {
        $this->model = $model;
        $this->viewPath = $viewPath;
    }

    /** List with filters + pagination */
    public function index($filters = [], $perPage = 20)
    {
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $offset = ($page - 1) * $perPage;

        $items = $this->model->all($filters, $perPage, $offset);
        $total = $this->model->count($filters);
        $pages = ceil($total / $perPage);

        require __DIR__ . "/../views/{$this->viewPath}/index.php";
    }

    /** Create new record */
    public function store($data, $redirectUrl)
    {
        $this->model->create($data);
        Flash::set('success', 'Record created successfully!');
        header("Location: $redirectUrl");
        exit;
    }

    /** Update record */
    public function update($id, $data, $redirectUrl)
    {
        $this->model->update($id, $data);
        Flash::set('success', 'Record updated successfully!');
        header("Location: $redirectUrl");
        exit;
    }

    /** Delete record */
    public function destroy($id, $redirectUrl)
    {
        $this->model->delete($id);
        Flash::set('success', 'Record deleted successfully!');
        header("Location: $redirectUrl");
        exit;
    }
}
