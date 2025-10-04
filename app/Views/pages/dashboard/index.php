<!DOCTYPE html>
<html lang="en">

<?php
use App\Core\View;
View::layout('head', ['title' => $title]);
?>

<body>
  <div class="drawer lg:drawer-open">
    <input
      id="mobile-drawer"
      type="checkbox"
      class="drawer-toggle"
    />

    <div class="drawer-content flex flex-col">
      <!-- Menu bar on mobile -->
      <div class="w-full navbar bg-base-100 shadow-sm lg:hidden">
        <div class="lg:hidden">
          <label
            for="mobile-drawer"
            aria-label="open sidebar"
            class="btn btn-square btn-ghost"
          >
            <img
              src="./public/icons/menu.svg"
              alt="Mobile menu icon"
            >
          </label>
        </div>
        <a
          href="/doan-phpcoban"
          class="text-xl flex items-center gap-2 font-semibold"
        >
          <img
            src="./public/icons/popcorn.svg"
            alt="Popcorn icon"
          >Ăn Vặt Shop</a>
      </div>

      <!-- Header -->
      <div class="shadow-sm bg-base-100 z-10 sticky top-0">
        <header class="navbar mx-auto justify-end">
          <div>
            <!-- User -->
            <h3 class="inline-block">Xin chào Admin!</h3>
            <div class="dropdown dropdown-end">
              <div
                tabindex="0"
                role="button"
                class="btn btn-ghost btn-circle avatar"
              >
                <div class="w-10 rounded-full">
                  <img
                    alt="User avatar"
                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"
                  />
                </div>
              </div>
              <ul
                tabindex="0"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-37 p-2 shadow [&_li>*]:text-sm"
              >
                <li>
                  <a class="justify-between">
                    Thông tin cá nhân
                  </a>
                </li>
                <li>
                  <a
                    class="justify-between"
                    href="<?php echo _HOST_URL ?>/dashboard"
                  >
                    Dashboard
                  </a>
                </li>
                <li><a>Cài đặt</a></li>
                <li id="btn-logout"><a>Đăng xuất</a></li>
            </div>
          </div>
        </header>
      </div>
      
      <main class="flex-1 lg:m-3">
        <!-- Stats Cards -->
        <div class="stats shadow w-full mb-2 stats-vertical lg:stats-horizontal">
          <div class="stat">
            <div class="stat-title">Doanh thu tháng này</div>
            <div class="stat-value text-primary">25.600.000 ₫</div>
            <div class="stat-desc">Tăng 21% so với tháng trước</div>
          </div>

          <div class="stat">
            <div class="stat-title">Đơn hàng mới</div>
            <div class="stat-value text-secondary">1,256</div>
            <div class="stat-desc">Tăng 15% so với tuần trước</div>
          </div>

          <div class="stat">
            <div class="stat-title">Khách hàng mới</div>
            <div class="stat-value">422</div>
            <div class="stat-desc">90 người trong hôm nay</div>
          </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="card bg-base-100 shadow-xl">
          <div class="card-body">
            <h2 class="card-title mb-4">Đơn hàng gần đây</h2>
            <div class="overflow-x-auto">
              <table class="table">
                <thead>
                  <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>#89412</th>
                    <td>Trần Văn An</td>
                    <td>04/10/2025</td>
                    <td>250.000 ₫</td>
                    <td>
                      <div class="badge badge-success">Đã giao</div>
                    </td>
                  </tr>
                  <tr>
                    <th>#89411</th>
                    <td>Nguyễn Thị Bình</td>
                    <td>04/10/2025</td>
                    <td>120.000 ₫</td>
                    <td>
                      <div class="badge badge-warning">Đang xử lý</div>
                    </td>
                  </tr>
                  <tr>
                    <th>#89410</th>
                    <td>Lê Minh Cường</td>
                    <td>03/10/2025</td>
                    <td>560.000 ₫</td>
                    <td>
                      <div class="badge badge-success">Đã giao</div>
                    </td>
                  </tr>
                  <tr>
                    <th>#89409</th>
                    <td>Phạm Thùy Dung</td>
                    <td>02/10/2025</td>
                    <td>85.000 ₫</td>
                    <td>
                      <div class="badge badge-error">Đã hủy</div>
                    </td>
                  </tr>
                  <tr>
                    <th>#89408</th>
                    <td>Võ Thành Long</td>
                    <td>01/10/2025</td>
                    <td>310.000 ₫</td>
                    <td>
                      <div class="badge badge-success">Đã giao</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Sidebar -->
    <div class="drawer-side shadow-sm">
      <label
        for="mobile-drawer"
        aria-label="close sidebar"
        class="drawer-overlay"
      ></label>
      <ul class="menu p-4 pt-0 min-h-full bg-base-100 text-base-content">
        <!-- Sidebar content here -->
        <div class="px-2 py-3 mt-1">
          <a
            href="/doan-phpcoban"
            class="text-xl flex items-center gap-2 font-semibold"
          >
            <img
              src="./public/icons/popcorn.svg"
              alt="Popcorn icon"
            >Ăn Vặt Shop</a>
        </div>
        <li class="menu-title">Tổng quan</li>
        <li>
          <a>
            <img
              src="./public/icons/house.svg"
              alt="House icon"
              class="size-5"
            >
            Dashboard
          </a>
        </li>

        <li class="menu-title">Quản lý</li>
        <li>
          <a>
            <img
              src="./public/icons/clipboard-list.svg"
              alt="Clipboard list icon"
              class="size-5"
            >
            Đơn hàng
          </a>
        </li>
        <li>
          <a>
            <img
              src="./public/icons/package.svg"
              alt="Package icon"
              class="size-5"
            >
            Sản phẩm
          </a>
        </li>
        <li>
          <a>
            <img
              src="./public/icons/users.svg"
              alt="Users icon"
              class="size-5"
            >
            Khách hàng
          </a>
        </li>

        <li class="menu-title">Khác</li>
        <li>
          <a>
            <img
              src="./public/icons/settings.svg"
              alt="Settings icon"
              class="size-5"
            >
            Cài đặt
          </a>
        </li>
      </ul>
    </div>
  </div>
  <script
    type="module"
    src="./public/js/pages/dashboard/index.js"
  ></script>
</body>

</html>