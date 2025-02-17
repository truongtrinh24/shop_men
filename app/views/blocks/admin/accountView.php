<?php
// Function to display customer list
function displayDataAccount($dataAccount)
{
    echo '<div class="container mt-3">';
    echo '<div class="row align-items-center">';
    echo '<div class="col">';
    echo '<h2 class="mb-3 ms-2">LIST ACCOUNT</h2>';
    echo '</div>';
    echo '<div class="col">';
    echo '<div class="input-group">';
    echo '<input type="text" class="form-control" placeholder="Search Account " aria-label="Search Account" aria-describedby="search-customer-icon" id="search-account-input">';
    echo '<button class="btn btn-primary" type="button" id="search-customer-icon" onclick="searchAccount()"><i class="bi bi-search"></i></button>';
    echo '<button class="btn btn-success ms-4" type="button" id="add-customer-button" data-bs-toggle="modal" data-bs-target="#addAccount"><i class="bi bi-person-plus-fill"></i></button>'; // Thêm nút "Thêm" với icon plus-circle
    echo '</div>';
    echo '</div>';  
    echo '</div>';
    echo '</div>';

    echo '<table id="accountList" class=" table table-hover text-center  mt-3">'; // Thêm id vào table

    echo '<thead>';
    echo '<tr>';
    echo '<th>STT</th>';
    echo '<th>Account ID</th>';
    echo '<th>Username</th>';
    echo '<th>Password</th>';
    echo '<th>Role ID</th>';
    echo '<th>Operations</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $stt = 1;
    if ($dataAccount) {
        foreach ($dataAccount as $account) {
            echo '<tr>';
            echo "<td>" . $stt . "</td>"; // Hiển thị giá trị của biến đếm STT
            echo '<td>' . $account['account_id'] . '</td>';
            echo '<td>' . $account['username'] . '</td>';
            echo '<td>' . $account['password'] . '</td>'; // Giải mã mật khẩu
            echo '<td>' . $account['role_id'] . '</td>';
            echo '<td class="d-flex justify-content-center">'; // Căn giữa nội dung của cột Function
            echo '<button class="btn btn-success me-1" data-bs-toggle="modal" data-bs-target="#updateAccount" onclick="openUpdateModal(\'' . $account['account_id'] . '\')"><i class="bi bi-pencil-square"></i></button>';
            echo '<button class="btn btn-danger" onclick="deleteProduct(\'' . $account['account_id'] . '\')"><i class="bi bi-person-dash"></i></button>';
            echo '</td>';

            echo '</tr>';
            $stt++;
        }
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}



// Function to generate pagination
function generatePagination($totalRows, $rowsPerPage, $currentPage)
{
    $totalPages = ceil($totalRows / $rowsPerPage);
    
    // Đảm bảo rằng số trang không nhỏ hơn 1
    $totalPages = max($totalPages, 1);

    echo '<nav aria-label="Page navigation" class="d-flex justify-content-center">';
    echo '<ul class="pagination">';

    echo '<li class="page-item">';
    echo '<a class="page-link" href="?page=' . ($currentPage - 1) . '" aria-label="Previous">';
    echo '<i class="bi bi-arrow-left"></i>';
    echo '</a>';
    echo '</li>';

    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'active' : '';
        echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '&limit=' . $rowsPerPage . '&offset=' . (($i - 1) * $rowsPerPage) . '">' . $i . '</a></li>';
    }

    echo '<li class="page-item">';
    echo '<a class="page-link" href="?page=' . ($currentPage + 1) . '" aria-label="Next">';
    echo '<i class="bi bi-arrow-right"></i>';
    echo '</a>';
    echo '</li>';

    echo '</ul>';
    echo '</nav>';
}


$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$rowsPerPage = 5;

$offset = ($currentPage - 1) * $rowsPerPage;

$customer = new accountModel();


$totalRows = $customer->getTotalQuantityAccount();

$dataCustomer = $customer->getAllAccount($rowsPerPage, $offset);

displayDataAccount($dataCustomer);

generatePagination($totalRows, $rowsPerPage, $currentPage);
?>

<div class="modal fade" id="updateAccount" tabindex="-1" aria-labelledby="updateProduct xModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Update Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="accountUpdate" class="text-center">

                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="userSelectUpdate" name="userSelectUpdate" readonly>


                    <label for="newInput">Password</label>
                    <input type="password" class="form-control" id="password" name="passwordName">

                    <label for="roleSelect">Role ID</label>
                    <select class="form-select" id="roleSelectUpdate" name="roleSelect">
                        <?php
                        $dataRole = $customer->getAllRoleId();
                        if ($dataRole) {
                            foreach ($dataRole as $role) {
                                echo '<option value="' . $role['role_id'] . '">' . $role['role_id'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" id="accountId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateAccount()">Update</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addAccount" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Add Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="accountAdd" class="text-center">

                    <label for="username">Username</label>
                    <select class="form-select" id="userSelectAdd" name="userSelect">
                        <option value="">Chọn username</option>
                        <?php
                        $dataCustomer = $customer->getAllEmployeeId();
                        if ($dataCustomer) {
                            foreach ($dataCustomer as $employee) {
                                echo '<option value="' . $employee['employee_id'] . '">' . $employee['employee_id'] . '</option>';
                            }
                        }
                        ?>
                    </select>

                    <label for="newInput">Password</label>
                    <input type="password" class="form-control" id="passwordAdd" name="passwordName" placeholder="Enter Password">

                    <label for="roleSelect">Role ID</label>
                    <select class="form-select" id="roleSelectAdd" name="roleSelect">
                        <option>Chọn quyền</option>

                        <?php
                        $dataRole = $customer->getAllRoleId();
                        if ($dataRole) {
                            foreach ($dataRole as $role) {
                                echo '<option value="' . $role['role_id'] . '">' . $role['role_id'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <input type="hidden" id="accountId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addAccountNew()">Comfirm</button>
            </div>
        </div>
    </div>
</div>