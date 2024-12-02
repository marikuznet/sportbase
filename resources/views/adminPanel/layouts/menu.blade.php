<ul class="c-sidebar-nav">
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::route()->getName() == 'admin.customers' ? 'c-active' : '' }}"
           href="{{ route('admin.customers') }}">
            <i class="c-sidebar-nav-icon cil-user"></i> Пользователи
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/sport-objects/*') ? 'c-active' : '' }}"
           href="{{ route('admin.sport-objects.checking') }}">
            <i class="c-sidebar-nav-icon cil-tennis-ball"></i> Спортивные объекты
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/applications/*') ? 'c-active' : '' }}"
           href="{{ route('admin.applications.direct') }}">
            <i class="c-sidebar-nav-icon cil-notes"></i> Заявки и отклики
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/deals/*') ? 'c-active' : '' }}"
           href="{{ route('admin.deals.processing') }}">
            <i class="c-sidebar-nav-icon cil-monitor"></i> Сделки
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/cooperation_feedbacks_moderating') ? 'c-active' : '' }}"
           href="{{ route('admin.cooperation_feedbacks_moderating') }}">
            <i class="c-sidebar-nav-icon cil-notes"></i> Отзывы о сотрудничестве
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/advertisment_and_seo_price') ? 'c-active' : '' }}"
           href="{{ route('admin.advertisment_and_seo_price') }}">
            <i class="c-sidebar-nav-icon cil-notes"></i> Реклама и продвижение
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/bills_list') ? 'c-active' : '' }}"
           href="{{ route('admin.bills_list') }}">
            <i class="c-sidebar-nav-icon cil-money"></i> Сметы и счета
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/finantial_operations_payment_bills') ? 'c-active' : '' }}"
           href="{{ route('admin.finantial_operations_payment_bills') }}">
            <i class="c-sidebar-nav-icon cil-money"></i> Финансовые операции
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/news') ? 'c-active' : '' }}"
           href="{{ route('admin.news') }}">
            <i class="c-sidebar-nav-icon cil-newspaper"></i> Новости
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link {{ Request::is('admin/payment-details') ? 'c-active' : '' }}"
           href="{{ route('admin.payment-details') }}">
            <i class="c-sidebar-nav-icon cil-settings"></i> Настройки
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('auth.logout') }}">
            <i class="c-sidebar-nav-icon cil-exit-to-app"></i> Выйти
        </a>
    </li>
</ul>
