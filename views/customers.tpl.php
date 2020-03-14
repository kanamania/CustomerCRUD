<div class="table-wrapper">
    <div class="table-title">
        <div class="row">
            <div class="col-sm-6">
                <h2><?=$header?></h2>
            </div>
            <div class="col-sm-6">
                <? if(isset($trash)){ ?>
                    <a href="/" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                        <span>Customers</span></a>
                <? } else { ?>
                <a href="/trash" class="btn btn-danger"><i class="fa fa-trash"></i>
                    <span>Trash Bin</span></a>
                <a href="#addCustomerModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus-circle"></i>
                    <span>Add New Customer</span></a>
                <? } ?>
            </div>
        </div>
    </div>
    <table id="customersTable" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Town</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($customers as $customer) { ?>
        <tr>
            <td><?=$customer['id']?></td>
            <td><?=$customer['first_name']." ".$customer['last_name']?></td>
            <td><?=$customer['gender']?></td>
            <td><?=$customer['town_name']?></td>
            <td>
                <? if(!isset($trash)){ ?>
                <a data-id="<?=$customer['id']?>"
                   data-firstname="<?=$customer['first_name']?>"
                   data-lastname="<?=$customer['last_name']?>"
                   data-gender_id="<?=$customer['gender_id']?>"
                   data-town="<?=$customer['town_name']?>"
                   href="#editCustomerModal" class="edit" data-toggle="modal">
                    <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                </a>
                <a data-id="<?=$customer['id']?>" href="#deleteCustomerModal" class="delete" data-toggle="modal">
                    <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                </a>
                <? } else { ?>
                <a data-id="<?=$customer['id']?>" href="#restoreCustomerModal" class="restore" data-toggle="modal">
                    <i class="fa fa-upload" data-toggle="tooltip" title="Restore"></i>
                </a>
                <a data-id="<?=$customer['id']?>" data-soft="0" href="#deleteCustomerModal" class="delete_forever" data-toggle="modal">
                    <i class="fa fa-times" data-toggle="tooltip" title="Delete Forever"></i>
                </a>
                <? } ?>
            </td>
        </tr>
        <? } ?>
        </tbody>
    </table>
</div>
<!-- Edit Modal HTML -->
<div id="addCustomerModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <input type="hidden" name="action" value="add">
                <div class="modal-header">
                    <h4 class="modal-title">Add Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>First name</label>
                            <input name="customer[first_name]" type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Last name</label>
                            <input name="customer[last_name]" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Gender</label>
                            <select name="customer[gender_id]" class="form-control" required>
                                <? foreach ($genders as $gender) { ?>
                                    <option value="<?= $gender['id'] ?>"><?= $gender['gender_name'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Town</label>
                            <input type="text" name="customer[town_name]" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Modal HTML -->
<div id="editCustomerModal" class="modal show">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="customer[id]" id="customerId">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>First name</label>
                            <input id="editFirstname" name="customer[first_name]" type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Last name</label>
                            <input id="editLastname" name="customer[last_name]" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Gender</label>
                            <select id="editGender" name="customer[gender_id]" class="form-control" required>
                                <? foreach ($genders as $gender) { ?>
                                    <option value="<?= $gender['id'] ?>"><?= $gender['gender_name'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Town</label>
                            <input id="editTownname" type="text" name="customer[town_name]" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-info" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteCustomerModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <input type="hidden" id="deleteAction" name="action" value="delete">
                <input type="hidden" id="deleteId" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this customer?</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal HTML -->
<div id="restoreCustomerModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <input type="hidden" name="action" value="restore">
                <input type="hidden" id="restoreId" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Restore Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to restore this customer?</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Restore">
                </div>
            </form>
        </div>
    </div>
</div>