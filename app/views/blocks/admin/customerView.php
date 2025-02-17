    <?php
    // Function to display customer list
    function displayDataAccount($dataCustomer)
    {
        echo '<div class="container mt-3">';
        echo '<div class="row align-items-center">';
        echo '<div class="col">';
        echo '<h2 class="mb-3 ms-2">LIST CUSTOMER</h2>';
        echo '</div>';
        echo '<div class="col">';
        echo '<div class="input-group">';
        echo '<input type="text" class="form-control" placeholder="Search Account " aria-label="Search Account" aria-describedby="search-customer-icon" id="search-customer-input">';
        echo '<button class="btn btn-primary" type="button" id="search-customer-icon" onclick="searchCustomer()"><i class="bi bi-search"></i></button>';
        echo '</div>';
        echo '</div>';  
        echo '</div>';
        echo '</div>';

        echo '<table id="accountList" class=" table table-hover text-center  mt-3">'; // Thêm id vào table

        echo '<thead>';
        echo '<tr>';
        echo '<th>STT</th>';
        echo '<th>Customer ID</th>';
        echo '<th>Customer Name</th>';
        echo '<th>Customer Address</th>';
        echo '<th>Customer Phone</th>';
        echo '<th>Customer Email</th>';
        echo '<th>Operations</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $stt = 1;
        if ($dataCustomer) {
            foreach ($dataCustomer as $customer) {
                echo '<tr>';
                echo "<td>" . $stt . "</td>"; // Hiển thị giá trị của biến đếm STT
                echo '<td>' . $customer['customer_id'] . '</td>';
                echo '<td>' . $customer['customer_name'] . '</td>';
                echo '<td>' . $customer['customer_address'] . '</td>'; // Giải mã mật khẩu
                echo '<td>' . $customer['customer_phone'] . '</td>';
                echo '<td>' . $customer['customer_email'] . '</td>';

                echo '<td class="d-flex justify-content-center">'; // Căn giữa nội dung của cột Function
                echo '<button class="btn btn-success me-1" data-bs-toggle="modal" data-bs-target="#updateCustomer" onclick="openUpdateModal(\'' . $customer['customer_id'] . '\')"><i class="bi bi-pencil-square"></i></button>';
                // echo '<button class="btn btn-danger" onclick="deleteCustomer(\'' . $customer['customer_id'] . '\')"><i class="bi bi-person-dash"></i></button>';
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

    $customer = new customerModel();


    $totalRows = $customer->getTotalQuantityAccount();

    $dataCustomer = $customer->getAllAccount($rowsPerPage, $offset);

    displayDataAccount($dataCustomer);

    generatePagination($totalRows, $rowsPerPage, $currentPage);
    ?>

    <div class="modal fade" id="updateCustomer" tabindex="-1" aria-labelledby="updateProduct xModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProductModalLabel">Update Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="accountUpdate" class="text-center">

                        <label for="username">Customer ID</label>
                        <input type="text" class="form-control" id="customerId" name="userSelectUpdate" readonly disabled>


                        <label for="newInput">Customer Name</label>
                        <input type="text" class="form-control" id="customerName" name="passwordName">

                        <label for="newInput">Customer Address</label>
                        <input type="text" class="form-control" id="customerAddress" name="passwordName">

                        <label for="newInput">Customer Phone</label>
                        <input type="text" class="form-control" id="customerPhone" name="passwordName">

                        <label for="newInput">Customer Email</label>
                        <input type="text" class="form-control" id="customerEmail" name="passwordName">

                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateCustomer()">Update</button>
                </div>
            </div>
        </div>
    </div>

