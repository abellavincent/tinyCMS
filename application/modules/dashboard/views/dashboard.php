    
    <div class="content-wrapper">
        <h3 class="page-heading mb-4" style="">Dashboard</h3>
        <p>Welcome back, <?php echo $this->session->userdata('first_name');?>!</p>

        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <h4 class="text-danger">
                                    <i class="fa fa-list-alt highlight-icon" aria-hidden="true"></i>
                                </h4>
                            </div>
                            <div class="float-right">
                                <p class="card-text text-dark">Posts</p>
                                <h4 class="bold-text"><?php echo $posts_count[0]->totalPublish; ?></h4>
                            </div>
                        </div>
                        <p class="text-muted">
                            <i class="fa fa-check-circle mr-1" aria-hidden="true"></i> All published posts
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <h4 class="text-warning">
                                    <i class="fa fa-file-text-o highlight-icon" aria-hidden="true"></i>
                                </h4>
                            </div>
                            <div class="float-right">
                                <p class="card-text text-dark">Pages</p>
                                <h4 class="bold-text"><?php echo $pages_count[0]->totalPublish; ?></h4>
                            </div>
                        </div>
                        <p class="text-muted">
                            <i class="fa fa-bookmark-o mr-1" aria-hidden="true"></i> All active pages
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <h4 class="text-success">
                                    <i class="fa fa-th-list highlight-icon" aria-hidden="true"></i>
                                </h4>
                            </div>
                            <div class="float-right">
                                <p class="card-text text-dark">Categories</p>
                                <h4 class="bold-text"><?php echo $categories_count; ?></h4>
                            </div>
                        </div>
                        <p class="text-muted">
                            <i class="fa fa-th-large mr-1" aria-hidden="true"></i> Blog categories
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <h4 class="text-primary">
                                    <i class="fa fa-users highlight-icon" aria-hidden="true"></i>
                                </h4>
                            </div>
                            <div class="float-right">
                                <p class="card-text text-dark">Users</p>
                                <h4 class="bold-text"><?php echo $users_count[0]->All; ?></h4>
                            </div>
                        </div>
                        <p class="text-muted">
                            <i class="fa fa-check-square-o mr-1" aria-hidden="true"></i> All site users
                        </p>
                    </div>
                </div>
            </div>
        </div>

        

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <?php if($categories): ?>
                            <?php foreach($categories as $item):?>
                                <p><a target="_blank" href="<?php echo site_url('category/post/'.$item->slug);?>"><?php echo $item->name;?></a></p>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Posts</h5>
                        
                        <?php if($recent_posts): ?>
                            <?php foreach($recent_posts as $item):?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="<?php echo site_url().$item->image;?>" class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <a href="<?php echo site_url('post/'.$item->id.'/'.$item->slug.'');?>" target="_blank"><?php echo $item->title;?></a>
                                    </div>
                                </div>
                                <br>   
                            <?php endforeach;?>
                        <?php endif;?>

                    </div>
                </div>
            </div>



            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Shortcuts</h5>
                        <p><a href="<?php echo site_url('admin/blogs');?>">All Posts</a></p>
                        <!-- <p><a href="<?php echo site_url('admin/blogs/categories');?>">Blog Categories</a></p> -->
                        <p><a href="<?php echo site_url('admin/post/add');?>">Add New Article</a></p>
                        <p><a href="<?php echo site_url('admin/users/profile');?>">Manage Profile</a></p>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div><!--./card deck-->
        

</div>


