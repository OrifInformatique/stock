<style>
    body {
        padding-top: 70px;
        background: #eee;
    }

    .navbar {
        -moz-box-shadow: rgba(0, 0, 0, 0.09) 0 2px 0;
        -webkit-box-shadow: rgba(0, 0, 0, 0.09) 0 2px 0;
        box-shadow: rgba(0, 0, 0, 0.09) 0 2px 0;
    }

    .navbar .navbar-brand {
        font-weight: bold;
        letter-spacing: -1px;
        font-size: 20px;
        color: #dd5638;
    }

    .navbar-right {
        margin-right: 0;
    }

    .table tbody > tr > td.middle {
        vertical-align: middle;
    }

    .media {
        padding: 10px 0;
    }

    .media img, .fileinput .thumbnail, .thumbnail img {
        border-radius: 50%;
    }

    .media-left {
        padding: 0 20px;
    }

    .media-heading {
        color: #dd5638;
        margin-bottom: 10px;
    }

    .media-body {
        padding-top: 15px;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
</style>

<!-- content -->
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item active">All Contact <span class="badge">10</span></a>
                <a href="" class="list-group-item">Family <span class="badge">4</span></a>
                <a href="" class="list-group-item">Friends <span class="badge">3</span></a>
                <a href="" class="list-group-item">Other <span class="badge">3</span></a>
            </div>
        </div><!-- /.col-md-3 -->

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Add Contact</strong>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name" class="control-label col-md-3">Name</label>
                                    <div class="col-md-8">
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="company" class="control-label col-md-3">Company</label>
                                    <div class="col-md-8">
                                        <input type="text" name="company" id="company" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="control-label col-md-3">Email</label>
                                    <div class="col-md-8">
                                        <input type="text" name="email" id="email" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="control-label col-md-3">Phone</label>
                                    <div class="col-md-8">
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="control-label col-md-3">Address</label>
                                    <div class="col-md-8">
                                        <textarea name="address" id="address" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="group" class="control-label col-md-3">Group</label>
                                    <div class="col-md-5">
                                        <select name="group" id="group" class="form-control">
                                            <option value="">Select group</option>
                                            <option value="1">Family</option>
                                            <option value="2">Friend</option>
                                            <option value="3">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#" id="add-group-btn" class="btn btn-default btn-block">Add Group</a>
                                    </div>
                                </div>
                                <div class="form-group" id="add-new-group">
                                    <div class="col-md-offset-3 col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="new_group" id="new_group" class="form-control">
                          <span class="input-group-btn">
                            <a href="#" class="btn btn-default">
                                <i class="glyphicon glyphicon-ok"></i>
                            </a>
                          </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                        <img src="http://placehold.it/150x150" alt="Photo">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px;"></div>
                                    <div class="text-center">
                                        <span class="btn btn-default btn-file"><span
                                                class="fileinput-new">Choose Photo</span><span class="fileinput-exists">Change</span><input
                                                type="file" name="..."></span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="#" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>