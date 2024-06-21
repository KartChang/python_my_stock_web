<?php
$routerClass = $this->router->class;
$routerMethod = $this->router->method;
// $header_info = $this->my_function->Get_Header_Info(isset($id)?$id:null);
?>

                <!-- Spinner Start -->
                <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->


                <!-- Sidebar Start -->
                <div class="sidebar pe-4 pb-3">
                    <nav class="navbar bg-secondary navbar-dark">
                        <a href="<?php echo base_url()?>" class="navbar-brand mx-4 mb-3">
                            <h3 class="text-white"><?php echo config_item('webName')?></h3>
                        </a>
                        <div class="navbar-nav w-100">
                            <a href="<?php echo base_url()?>" class="nav-item nav-link <?php echo $this->router->fetch_class() == 'home' ? 'active' : '' ?>"><i class="fa fa-home me-2"></i>CM開通查詢</a>
                            <a href="<?php echo base_url()?>sms" class="nav-item nav-link <?php echo $this->router->fetch_class() == 'sms' ? 'active' : '' ?>"><i class="fa fa-mobile me-2"></i>簡訊發送</a>
                            <a href="<?php echo base_url()?>mac_tool" class="nav-item nav-link <?php echo $this->router->fetch_class() == 'mac_tool' ? 'active' : '' ?>"><i class="fa fa-retweet me-2"></i>CMMAC查詢</a>
                            <a href="<?php echo base_url()?>ont_static_ip" class="nav-item nav-link <?php echo $this->router->fetch_class() == 'ont_static_ip' ? 'active' : '' ?>"><i class="fa fa-building me-2"></i>ONT綁固I</a>
                            <!-- <a href="<?php echo base_url()?>ont" class="nav-item nav-link <?php echo $this->router->fetch_class() == 'ont' ? 'active' : '' ?>"><i class="fa fa-info-circle me-2"></i>ONT連接狀態</a> -->
                            <a href="<?php echo base_url()?>device" class="nav-item nav-link <?php echo $this->router->fetch_class() == 'device' ? 'active' : '' ?>"><i class="fa fa-info-circle me-2"></i>設備連接狀態</a>
                            <!-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                                <div class="dropdown-menu bg-transparent border-0">
                                    <a href="button.html" class="dropdown-item">Buttons</a>
                                    <a href="typography.html" class="dropdown-item">Typography</a>
                                    <a href="element.html" class="dropdown-item">Other Elements</a>
                                </div>
                            </div>
                            <a href="widget.html" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
                            <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
                            <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
                            <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                                <div class="dropdown-menu bg-transparent border-0">
                                    <a href="signin.html" class="dropdown-item">Sign In</a>
                                    <a href="signup.html" class="dropdown-item">Sign Up</a>
                                    <a href="404.html" class="dropdown-item">404 Error</a>
                                    <a href="blank.html" class="dropdown-item">Blank Page</a>
                                </div>
                            </div> -->
                        </div>
                    </nav>
                </div>
                <!-- Sidebar End -->