<div class="sidebar">
    <div class="logo-details">
        <i class='bx bxs-color side-toggle'></i>
        <span class="logo_name fst-italic">{{ __('Pintar Niaga') }}</span>
        <i class='bx bx-chevrons-left side-toggle menu-arrow mx-4'></i>
    </div>
    <ul class="nav-link">
        <li>
            @php
                $currentRoute = Request::url();
                ##dd($currentRoute);
                $uris = explode('/', $currentRoute);
                ##dd($uris);
                $cp_dashboard = "/".$uris[3]."/".$uris[4]."/";
                $ac_dashboard = "/".$uris[3]."/".$uris[4]."/accounts/";
                $ct_dashboard = "/".$uris[3]."/".$uris[4]."/categories/";
                $pd_dashboard = "/".$uris[3]."/".$uris[4]."/products/";
                $ig_dashboard = "/".$uris[3]."/".$uris[4]."/inventory/";
                $pc_dashboard = "/".$uris[3]."/".$uris[4]."/purchase/";
                $sl_dashboard = "/".$uris[3]."/".$uris[4]."/sale/";
                $tc_cashin = "/".$uris[3]."/".$uris[4]."/cash-in/create/";
                $tc_payment = "/".$uris[3]."/".$uris[4]."/payment/create/";
                ##dd($cp_dashboard);
            @endphp
            <a href="{{ $cp_dashboard }}">
                <i class="bx bx-grid-alt"></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="{{ $cp_dashboard }}">Company Dashboard</a>
                </li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="{{ $ac_dashboard }}">
                    <i class='bx bxs-bank' ></i>
                    <span class="link_name">Accounts</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <a class="link_name" href="{{ $ac_dashboard }}">Accounts</a>
                </li>
                <li>
                    <a href="{{ $tc_cashin }}">Deposit</a>
                </li>
                <li>
                    <a href="{{ $tc_payment }}">Payment</a>
                </li>
                <li>
                    <a href="#">Reconciliation</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ $ct_dashboard }}">
                <i class='bx bx-purchase-tag-alt' ></i>
                <span class="link_name">Categories</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="{{ $ct_dashboard }}">Categories</a>
                </li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="{{ $pd_dashboard }}">
                    <i class="bx bx-basket"></i>
                    <span class="link_name">Products</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <a class="link_name" href="{{ $pd_dashboard }}">Products</a>
                </li>
                <li>
                    <a href="{{ $ig_dashboard }}">Inventory</a>
                </li>
                <li>
                    <a href="#">Move Stock</a>
                </li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="{{ $pc_dashboard }}">
                    <i class='bx bx-package' ></i>
                    <span class="link_name">Purchase</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <a class="link_name" href="{{ $pc_dashboard }}">Purchase</a>
                </li>
                <li>
                    <a href="#">Purchase history</a>
                </li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="{{ $sl_dashboard }}">
                    <i class='bx bxs-cart' ></i>
                    <span class="link_name">Sale</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <a class="link_name" href="{{ $sl_dashboard }}">Sale</a>
                </li>
                <li>
                    <a href="#">Sale History</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class="bx bx-cog"></i>
                <span class="link_name">Settings</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="#">Settings</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/index">
                <i class="bx bx-door-open"></i>
                <span class="link_name">Return</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <a class="link_name" href="/index">Return Home</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
