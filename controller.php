<?php

route('/', function () {
    global $db;
    $data['pagetitle'] = 'Customers';
    $page['header'] = 'Manage Customers';
    if ($_POST['action'] == 'add') {
        $check = $db->insert('customers', $_POST['customer']);
        $status = $check ? 'success' : 'error';
        $message = $check ? 'Customer #' . $_POST['id'] . ' created successfully' : 'Operation failed please try again';
        $data['status'] = ['status' => $status, 'message' => $message];
    } elseif ($_POST['action'] == 'edit') {
        $check = $db->update('customers', $_POST['customer']['id'], $_POST['customer']);
        $status = $check ? 'success' : 'error';
        $message = $check ? 'Customer #' . $_POST['customer']['id'] . ' updated successfully' : 'Operation failed please try again';
        $data['status'] = ['status' => $status, 'message' => $message];
    } elseif ($_POST['action'] == 'delete') {
        $check = $db->delete('customers', $_POST['id']);
        $status = $check ? 'success' : 'error';
        $message = $check ? 'Customer #' . $_POST['id'] . ' deleted successfully' : 'Operation failed please try again';
        $data['status'] = ['status' => $status, 'message' => $message];
    }
    $page['customers'] = $db->query('SELECT c.*, g.gender_name as gender FROM customers c LEFT JOIN genders g on c.gender_id = g.id WHERE c.is_deleted != 1');
    $page['genders'] = $db->getAll('genders');
    $data['pagebody'] = loadView('views/customers.tpl.php', $page);
    return view($data);

});
route('/trash', function () {
    global $db;
    $data['pagetitle'] = 'Deleted Customers';
    $page['header'] = 'Manage Deleted Customers';
    if ($_POST['action'] == 'restore') {
        $check = $db->restore('customers', $_POST['id']);
        $status = $check ? 'success' : 'error';
        $message = $check ? 'Customer #' . $_POST['id'] . ' have been restored successfully' : 'Operation failed please try again';
        $page['status'] = ['status' => $status, 'message' => $message];
    }
    if ($_POST['action'] == 'forever') {
        $check = $db->delete('customers', $_POST['id'], false);
        $status = $check ? 'success' : 'error';
        $message = $check ? 'Customer #' . $_POST['id'] . ' have been deleted forever' : 'Operation failed please try again';
        $page['status'] = ['status' => $status, 'message' => $message];
    }
    $page['customers'] = $db->query('SELECT c.*, g.gender_name as gender FROM customers c LEFT JOIN genders g on c.gender_id = g.id WHERE c.is_deleted != 0');
    $page['genders'] = $db->getAll('genders');
    $page['trash'] = 1;
    $data['pagebody'] = loadView('views/customers.tpl.php', $page);
    return view($data);

});
