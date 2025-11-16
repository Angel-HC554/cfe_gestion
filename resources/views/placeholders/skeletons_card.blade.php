<div>
            <style>
                .fast-pulse {
                    animation: fastPulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                }
                @keyframes fastPulse {
                    0%, 100% {
                        opacity: 0.4;
                        transform: scale(1);
                    }
                    50% {
                        opacity: 0.8;
                        transform: scale(1.05);
                    }
                }
            </style>

            <!-- Filter section skeleton -->
            <div class="flex flex-row justify-between border-1 shadow-sm items-center bg-white rounded-md border-t-3 border-t-emerald-700/40 p-3 mb-4">
                <div class="flex flex-col text-gray-700 font-medium">
                    <div class="w-12 h-4 bg-gray-200 fast-pulse rounded mb-1"></div>
                    <div class="w-64 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                </div>
                <div class="flex flex-col text-gray-700 font-medium">
                    <div class="w-12 h-4 bg-gray-200 fast-pulse rounded mb-1"></div>
                    <div class="w-64 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                </div>
                <div class="flex flex-col text-gray-700 font-medium">
                    <div class="w-12 h-4 bg-gray-200 fast-pulse rounded mb-1"></div>
                    <div class="w-64 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                </div>
                <div class="w-24 h-8 bg-gray-200 fast-pulse rounded-md"></div>
            </div>

            <!-- Controls section skeleton -->
            <div class="flex justify-between items-center my-5">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-4 bg-gray-200 fast-pulse rounded"></div>
                    <div class="w-16 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-16 h-4 bg-gray-200 fast-pulse rounded"></div>
                    <div class="w-64 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                </div>
            </div>

            <!-- Table skeleton -->
            <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 border-1">
                    <thead class="text-xs text-green-950 uppercase bg-accent-content/20">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="w-20 h-4 bg-gray-300 fast-pulse rounded"></div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="w-24 h-4 bg-gray-300 fast-pulse rounded"></div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="w-16 h-4 bg-gray-300 fast-pulse rounded"></div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="w-12 h-4 bg-gray-300 fast-pulse rounded"></div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="w-16 h-4 bg-gray-300 fast-pulse rounded"></div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="w-8 h-4 bg-gray-300 fast-pulse rounded"></div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="w-12 h-4 bg-gray-300 fast-pulse rounded"></div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="w-16 h-4 bg-gray-300 fast-pulse rounded"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr class="bg-white border-b border-zinc-200">
                            <td class="px-6 py-4">
                                <div class="w-12 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-20 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-16 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-24 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-6 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-20 h-6 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="bg-white border-b border-zinc-200">
                            <td class="px-6 py-4">
                                <div class="w-14 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-18 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-20 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-22 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-8 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-24 h-6 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="bg-white border-b border-zinc-200">
                            <td class="px-6 py-4">
                                <div class="w-10 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-22 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-18 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-26 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-4 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-18 h-6 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="bg-white border-b border-zinc-200">
                            <td class="px-6 py-4">
                                <div class="w-16 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-16 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-14 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-20 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-10 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-22 h-6 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5 -->
                        <tr class="bg-white border-b border-zinc-200">
                            <td class="px-6 py-4">
                                <div class="w-12 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-24 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-16 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-18 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-6 h-4 bg-gray-200 fast-pulse rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-16 h-6 bg-gray-200 fast-pulse rounded-md"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                    <div class="w-8 h-8 bg-gray-200 fast-pulse rounded-md"></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination skeleton -->
            <div class="mt-4 flex justify-center space-x-2">
                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded"></div>
                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded"></div>
                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded"></div>
                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded"></div>
                <div class="w-8 h-8 bg-gray-200 fast-pulse rounded"></div>
            </div>
        </div>