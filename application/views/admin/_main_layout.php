
<?php $this->load->view('admin/includes/header.php');?>

<body>

  <div class="container-scroller">

    <!-- Top Branding Section  -->
    <nav class="navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      	
      	<div class="bg-white text-center navbar-brand-wrapper">
        	<a class="navbar-brand brand-logo" href="<?php echo site_url('admin/dashboard');?>"><img src="<?php echo site_url('assets/images/logo.png');?>" /></a>
        	<a class="navbar-brand brand-logo-mini" href="<?php echo site_url('admin/dashboard');?>"><img src="<?php echo site_url('assets/images/logo-icon.png');?>" alt=""></a>
      	</div>

      	<div class="navbar-menu-wrapper d-flex align-items-center">
        	<button class="navbar-toggler navbar-toggler d-none d-lg-block navbar-dark align-self-center mr-3" type="button" data-toggle="minimize">
          		<span class="navbar-toggler-icon"></span>
        	</button>

        	<form class="form-inline mt-2 mt-md-0 d-none d-lg-block">
          		<input class="form-control mr-sm-2 search" type="text" placeholder="Search">
        	</form>

        	<ul class="navbar-nav ml-lg-auto d-flex align-items-center flex-row" >
          		
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url();?>" target="_blank"><i class="fa fa-globe"></i></a>
                </li>
                 
          		<li class="nav-item">
            		<a class="nav-link profile-pic" href="<?php echo site_url('admin/users/profile');?>"><img class="rounded-circle" src="<?php echo site_url().$this->session->userdata('image');?>" alt=""></a>
          		</li>

          		
       		</ul>

        	<button class="navbar-toggler navbar-dark navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          		<span class="navbar-toggler-icon"></span>
        	</button>
      	</div>
    </nav>


    <!-- Content -->
    <div class="container-fluid">
      	<div class="row row-offcanvas row-offcanvas-right">
        
	        <!-- Side Navigation -->
	        <nav class="bg-white sidebar sidebar-offcanvas" id="sidebar">
	          	<div class="user-info">
	            	<img src="<?php echo site_url().$this->session->userdata('image');?>" alt="">
	            	<p class="name"><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name');?></p>
	            	<p class="designation"><?php echo $this->session->userdata('user_role');?></p>
	            	<span class="online"></span>
	          	</div>

	         	<ul class="nav">
		            

		           	<?php if($admin_menu): foreach($admin_menu as $menu):?>
		           		<li class="nav-item <?php echo set_admin_navigation_active($menu->keyword);?>">
			              	
			              	<?php if(navigation_menu_has_child($menu->id) == TRUE):?>
			              		
			              		<a class="nav-link collapsed" data-toggle="collapse" href="#dropdown-<?php echo $menu->id;?>" aria-expanded="false" aria-controls="dropdown-<?php echo $menu->id;?>">
							      	<?php echo $menu->icon;?>
							      	<span class="menu-title"><?php echo $menu->title;?><i class="fa fa-sort-down"></i></span>
							    </a>

			              	<?php else:?>
			              		
			              		<a class="nav-link" href="<?php echo site_url($menu->url);?>">
				                	<?php echo $menu->icon;?>
				                	<span class="menu-title"><?php echo $menu->title;?></span>
				              	</a>

			              	<?php endif;?>

			              	<?php get_navigation_menu_nested($menu->id);?>
			            </li>
		           	<?php endforeach;endif;?>


	          </ul>
	        </nav>



        <!-- Main Body Content -->
        <?php $this->load->view($subview);?>
        <!-- Main Body Content -->

        <!-- Copyright Footer -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="float-right">
                <a href="#"><?php echo $meta_title;?></a> &copy; 2017
            </span>
          </div>
        </footer>
        <!-- Copyright Footer -->
       
      </div><!--./container-scroll-->
    </div><!--./container-fluid-->
  </div><!--./row-->


<?php $this->load->view('admin/includes/footer.php');?>