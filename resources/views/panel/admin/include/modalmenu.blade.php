<div class="modal fade apps-modal" id="appsModal" tabindex="-1" role="dialog" aria-labelledby="appsModalLabel"
    aria-hidden="true" data-backdrop="false">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ik ik-x-circle"></i></button>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="quick-search">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 ml-auto mr-auto">
                            <div class="input-wrap">
                                <input type="text" id="quick-search" class="form-control" placeholder="Search..." />
                                <i class="ik ik-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="container">
                    <div class="apps-wrap">
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-bar-chart-2"></i><span>{{ __('admin/tooltip.Dashboard') }}</span></a>
                        </div>
                        <div class="app-item dropdown">
                            <a href="#" class="dropdown-toggle" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="ik ik-command"></i><span>{{ __('admin/tooltip.Ui') }}</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">{{ __('admin/ui.actions') }}</a>
                                <a class="dropdown-item" href="#">{{ __('admin/tooltip.Another action') }}</a>
                                <a class="dropdown-item"
                                    href="#">{{ __('admin/tooltip.Something else here') }}</a>
                            </div>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-mail"></i><span>{{ __('admin/tooltip.Message') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-users"></i><span>{{ __('admin/tooltip.Accounts') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-shopping-cart"></i><span>{{ __('admin/tooltip.Sales') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-briefcase"></i><span>{{ __('admin/tooltip.Purchase') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-server"></i><span>{{ __('admin/tooltip.Menus') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-clipboard"></i><span>{{ __('admin/tooltip.Pages') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-message-square"></i><span>{{ __('admin/tooltip.Chats') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-map-pin"></i><span>{{ __('admin/tooltip.Contacts') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-box"></i><span>{{ __('admin/tooltip.Blocks') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-calendar"></i><span>{{ __('admin/tooltip.Events') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-bell"></i><span>{{ __('admin/tooltip.Notifications') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-pie-chart"></i><span>{{ __('admin/tooltip.Reports') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-layers"></i><span>{{ __('admin/tooltip.Tasks') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-edit"></i><span>{{ __('admin/tooltip.Blogs') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-settings"></i><span>{{ __('admin/tooltip.Settings') }}</span></a>
                        </div>
                        <div class="app-item">
                            <a href="#"><i
                                    class="ik ik-more-horizontal"></i><span>{{ __('admin/tooltip.More') }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
