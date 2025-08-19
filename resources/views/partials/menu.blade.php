<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('credit_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/wallets*") ? "c-show" : "" }} {{ request()->is("admin/transactions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-coins c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.credit.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('wallet_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.wallets.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/wallets") || request()->is("admin/wallets/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-wallet c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.wallet.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('transaction_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.transactions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/transactions") || request()->is("admin/transactions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-database c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.transaction.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('campaign_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/smss*") ? "c-show" : "" }} {{ request()->is("admin/emails*") ? "c-show" : "" }} {{ request()->is("admin/whats-apps*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-calendar-check c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.campaign.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('sms_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.smss.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/smss") || request()->is("admin/smss/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-comment-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.sms.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('email_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.emails.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/emails") || request()->is("admin/emails/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.email.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('whats_app_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.whats-apps.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/whats-apps") || request()->is("admin/whats-apps/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-whatsapp-square c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.whatsApp.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('contact_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.contacts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contacts") || request()->is("admin/contacts/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-address-book c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.contact.title') }}
                </a>
            </li>
        @endcan
        @can('template_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sms-templates*") ? "c-show" : "" }} {{ request()->is("admin/email-templates*") ? "c-show" : "" }} {{ request()->is("admin/whats-app-templates*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-fill-drip c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.template.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('sms_template_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sms-templates.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sms-templates") || request()->is("admin/sms-templates/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-comment-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.smsTemplate.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('email_template_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.email-templates.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/email-templates") || request()->is("admin/email-templates/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.emailTemplate.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('whats_app_template_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.whats-app-templates.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/whats-app-templates") || request()->is("admin/whats-app-templates/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-whatsapp-square c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.whatsAppTemplate.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('setup_master_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sms-setups*") ? "c-show" : "" }} {{ request()->is("admin/email-setups*") ? "c-show" : "" }} {{ request()->is("admin/whats-app-setups*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setupMaster.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('sms_setup_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sms-setups.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sms-setups") || request()->is("admin/sms-setups/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-comment-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.smsSetup.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('email_setup_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.email-setups.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/email-setups") || request()->is("admin/email-setups/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-envelope c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.emailSetup.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('whats_app_setup_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.whats-app-setups.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/whats-app-setups") || request()->is("admin/whats-app-setups/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-whatsapp-square c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.whatsAppSetup.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('organizer_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.organizers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/organizers") || request()->is("admin/organizers/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.organizer.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>