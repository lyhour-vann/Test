<?php
require_once 'connection.php';

$stmt = $conn->prepare("SELECT * FROM role WHERE status = 1 ");

$stmt->execute();

$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Management Table Design with Full Screen Table</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Existing styles remain the same until the animation part */
        .gradient-header {
            background: linear-gradient(to right,#ffae00, hsl(47, 100%, 60%) );
        }
        .scrollable-tbody {
            display: block;
            height: calc(100vh - 220px);
            overflow-y: auto;
            overflow-x: hidden;
        }
        thead, tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        th, td {
            width: auto;
            min-width: 100px;
            padding: 0.5rem 0.75rem;
        }
        .table-container {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: none;
        }
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .mx-auto.flex-grow {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .table-container {
            flex-grow: 1;
        }
        .shimmer-block {
            position: relative;
            overflow: hidden;
            background: #e0e0e0;
        }
        .shimmer-block::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.4) 50%,
                transparent 100%
            );
            animation: shimmer 1s infinite;
        }
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* New animation styles for popup */
        .popup-enter {
            animation: popupIn 0.3s ease-out forwards;
        }
        .popup-exit {
            animation: popupOut 0.3s ease-in forwards;
        }
        .overlay-enter {
            animation: overlayIn 0.3s ease-out forwards;
        }
        .overlay-exit {
            animation: overlayOut 0.3s ease-in forwards;
        }

        @keyframes popupIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        @keyframes popupOut {
            from {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            to {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }
        }
        @keyframes overlayIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes overlayOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 pl-6 pr-6 pt-6 font-sans min-h-screen flex flex-col">
    <!-- Existing HTML content remains the same -->
    <div class="mx-auto flex-grow">
        <h1 class="text-xl font-bold text-gray-800">Role Management</h1>
        <div class="flex justify-between items-center mb-6 mt-3 ">
                <div class="relative">
                    <input type="text" placeholder="Search..." 
                           class="border border-gray-300 rounded-lg py-1 px-3 pl-8 focus:outline-none focus:ring-2 focus:ring-orange-500 w-full max-w-xs text-sm ">
                    <svg class="w-4 h-4 absolute left-2 top-2.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <a href="create.php"class="bg-orange-500 text-white font-semibold py-1 px-3 rounded-lg hover:bg-orange-600 transition duration-200 text-sm">
                    +Add New
                </a>

                <!-- key jas -->
                <!-- <button id="add-new-btn" class="bg-orange-500 text-white font-semibold py-1 px-3 rounded-lg hover:bg-orange-600 transition duration-200 text-sm">
                    + Add New
                </button> -->
        </div>
        <div class="table-container">
            <table class="min-w-full text-sm">
                <thead class="gradient-header sticky top-0">
                    <tr>
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Role Name</th>
                        <th class="py-2 px-4">Description</th>
                        <th class="py-2 px-4">Action</th>
                    </tr>
                </thead>
                <tbody class="scrollable-tbody text-gray-600 bg-white text-center items-center font-semibold">
                <?php foreach($roles as $key => $role): ?>
                    <tr class="loading-row border-b border-gray-200 duration-300 hover:bg-gray-100">
                        <td class="py-2 px-6"><?php echo $key + 1 ?></td>
                        <td class="py-2 px-6"><?php echo $role['name']; ?></td>
                        <td class="py-2 px-6"><?php echo $role['description']; ?></td>
                        <td class="py-2 px-6">
                            <div class="flex pl-20 ">
                                <a href="#" class="flex ml-4 text-yellow-400 rounded-lg hover:bg-yellow-200 duration-500 py-1 px-3">Edit</a>
                                <a href="delete.php?id=<?php echo $role['id']; ?>" class="flex ml-4 text-red-500 rounded-lg hover:bg-red-200 duration-500 py-1 px-3">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="bg-white p-3 flex justify-center items-center space-x-2 text-sm">
                <button class="px-4 py-1 bg-orange-500 text-white rounded-lg hover:bg-orange-600">«</button>
                <button class="px-3 py-1 bg-orange-500 text-white rounded-lg hover:bg-orange-600">‹</button>
                <span class="px-3 py-1">Page 1 of 32 of 700 entries</span>
                <button class="px-3 py-1 bg-orange-500 text-white rounded-lg hover:bg-orange-600">›</button>
                <button class="px-4 py-1 bg-orange-500 text-white rounded-lg hover:bg-orange-600">»</button>
                <input type="number" value="1" min="1" max="5" class="border border-gray-300 rounded-lg py-1 px-2 w-12 text-center text-sm">
                <button class="px-3 py-1 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-sm">GO</button>
                
            </div>
        </div>
    </div>

    <div id="add-new-popup" class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col popup-content">
            <!-- Popup content remains the same -->
            <div class="p-8 pb-0 sticky top-0 bg-white z-10 rounded-xl ">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center ml-20 pl-20">
                    <svg class="w-6 h-6 mr-2 text-orange-500 ml-20 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Role
                </h2>
                <div class="flex flex-col gap-5">
                    <label for="role-name">Role Name</label>
                    <input type="text" placeholder="Enter Role Name"
                           class="p-2 pl-2  placeholder-gray-500 bg-white border-2 border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 placeholder:italic">
                    <label for="role-name">Description</label>
                    <input type="text" placeholder="Enter Desc"
                           class="flex h-60 pl-4 pb-40 placeholder-gray-500 bg-white border-2 border-gray-300 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 border-dashed placeholder:italic">
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-8 pt-0">
                <form id="add-product-form" class="space-y-6">
                    <!-- Form content remains the same -->
                </form>
            </div>
            <div class="rounded-xl p-8 pt-0 sticky bottom-0 bg-white z-10">
                <div class="flex justify-end items-center space-x-4">
                    <button type="button" id="cancel-btn" class="bg-gray-100 text-gray-700 font-semibold py-2.5 px-6 rounded-lg hover:bg-gray-200 transition duration-200 shadow-sm">Cancel (ESC)</button>
                    <button type="submit" form="add-role-form" class="bg-gradient-to-r from-[#F7B500] to-[#FF8800] text-white font-semibold py-2.5 px-6 rounded-lg hover:from-[#e0a400] hover:to-[#e07b00] transition duration-200 shadow-md">Save (CTRL + ENTER)</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get elements
        const addNewBtn = document.getElementById('add-new-btn');
        const popup = document.getElementById('add-new-popup');
        const cancelBtn = document.getElementById('cancel-btn');
        const popupContent = popup.querySelector('.popup-content');

        // Function to show popup with animation
        function showPopup() {
            popup.classList.remove('hidden');
            popup.classList.add('overlay-enter');
            popupContent.classList.add('popup-enter');
            
            // Remove animation classes after animation completes
            setTimeout(() => {
                popup.classList.remove('overlay-enter');
                popupContent.classList.remove('popup-enter');
            }, 300);
        }

        // Function to hide popup with animation
        function hidePopup() {
            popup.classList.add('overlay-exit');
            popupContent.classList.add('popup-exit');
            
            // Hide popup after animation completes
            setTimeout(() => {
                popup.classList.add('hidden');
                popup.classList.remove('overlay-exit');
                popupContent.classList.remove('popup-exit');
            }, 300);
        }

        // Event listeners
        addNewBtn.addEventListener('click', showPopup);
        cancelBtn.addEventListener('click', hidePopup);

        // Close popup when clicking outside
        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                hidePopup();
            }
        });

        // Close popup with ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !popup.classList.contains('hidden')) {
                hidePopup();
            }
        });
    </script>
</body>
</html>