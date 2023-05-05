@extends('layouts.master')
@section('content')
<div class="container px-6 mx-auto grid">
    <!-- component -->

    <div class="container mx-auto" x-data="datatables()" x-cloak>
        <div class="flex justify-between items-center">  
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Product
        </h2> 
        <div>
            <a class="flex items-center justify-center px-3 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            href="{{ route('products.create') }}">
            <i class="fa-solid fa-plus"></i>
            <span class="ml-2">Add</span>
            </a>
        </div>   
        </div>
     
        <div class="mb-4 flex justify-between items-center">
            <div class="flex-1 pr-4">
                <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
                    <div class="absolute inset-y-0 flex items-center pl-2">
                        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input class="w-1/2 rounded-lg border-0 shadow-lg pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:border-0 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search..." aria-label="Search" />
                </div>
            </div>
            <div>
                <div class="shadow rounded-lg flex">
                    <div class="relative">
                        <button @click.prevent="open = !open" class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                            </svg>
                            <span class="hidden md:block">Display</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                            <template x-for="heading in headings">
                                <label class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                    <div class="text-teal-600 mr-3">
                                        <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" checked @click="toggleColumn(heading.key)">
                                    </div>
                                    <div class="select-none text-gray-700" x-text="heading.value"></div>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg shadow overflow-y-hidden relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap table-striped relative">
                <thead>
                    <tr class="text-left">
                        <template x-for="heading in headings">
                            <th class="bg-gray-200 sticky top-0 border-b border-gray-200 px-6 py-4 text-gray-600 font-bold tracking-wider uppercase text-xs dark:text-white dark:bg-gray-800" x-text="heading.value" :x-ref="heading.key" :class="{ [heading.key]: true }"></th>
                        </template>
                    </tr>
                </thead>
                <tbody class="bg-white  dark:bg-gray-800">
                    <template x-for="user in users" :key="user.userId">
                        <tr>
                            <td class="border-t-[0.5px] border-gray-200 dark:border-gray-700 userId">
                                <span class="text-gray-900 dark:text-gray-100 text-sm px-6 py-3 flex items-center" x-text="user.userId"></span>
                            </td>
                            <td class="border-t-[0.5px] border-gray-200 dark:border-gray-700 firstName">
                                <span class="text-gray-900 dark:text-gray-100 text-sm px-6 py-3 flex items-center" x-text="user.firstName"></span>
                            </td>
                            <td class="border-t-[0.5px] border-gray-200 dark:border-gray-700 lastName">
                                <span class="text-gray-900 dark:text-gray-100 text-sm px-6 py-3 flex items-center" x-text="user.lastName"></span>
                            </td>
                            <td class="border-t-[0.5px] border-gray-200 dark:border-gray-700 emailAddress">
                                <span class="text-gray-900 dark:text-gray-100 text-sm px-6 py-3 flex items-center" x-text="user.emailAddress"></span>
                            </td>
                            <td class="border-t-[0.5px] border-gray-200 dark:border-gray-700 gender">
                                <span class="text-gray-900 dark:text-gray-100 text-sm px-6 py-3 flex items-center" x-text="user.gender"></span>
                            </td>
                            <td class="border-t-[0.5px] border-gray-200 dark:border-gray-700 phoneNumber">
                                <span class="text-gray-900 dark:text-gray-100 text-sm px-6 py-3 flex items-center" x-text="user.phoneNumber"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-200 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                    Showing 21-30 of 100
                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation">
                        <ul class="inline-flex items-center">
                            <li>
                                <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                        <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </li>
                            <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    1
                                </button>
                            </li>
                            <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    2
                                </button>
                            </li>
                            <li>
                                <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    3
                                </button>
                            </li>
                            <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    4
                                </button>
                            </li>
                            <li>
                                <span class="px-3 py-1">...</span>
                            </li>
                            <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    8
                                </button>
                            </li>
                            <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    9
                                </button>
                            </li>
                            <li>
                                <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                        <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </span>
            </div>

        </div>
    </div>

</div>
<script>
    function datatables() {
        return {
            headings: [{
                    'key': 'userId',
                    'value': 'ID'
                },
                {
                    'key': 'firstName',
                    'value': 'Firstname'
                },
                {
                    'key': 'lastName',
                    'value': 'Lastname'
                },
                {
                    'key': 'emailAddress',
                    'value': 'Email'
                },
                {
                    'key': 'gender',
                    'value': 'Gender'
                },
                {
                    'key': 'phoneNumber',
                    'value': 'Phone'
                }
            ],
            users: [{
                "userId": 1,
                "firstName": "Cort",
                "lastName": "Tosh",
                "emailAddress": "ctosh0@github.com",
                "gender": "Male",
                "phoneNumber": "327-626-5542"
            }, {
                "userId": 2,
                "firstName": "Brianne",
                "lastName": "Dzeniskevich",
                "emailAddress": "bdzeniskevich1@hostgator.com",
                "gender": "Female",
                "phoneNumber": "144-190-8956"
            }, {
                "userId": 3,
                "firstName": "Isadore",
                "lastName": "Botler",
                "emailAddress": "ibotler2@gmpg.org",
                "gender": "Male",
                "phoneNumber": "350-937-0792"
            }, {
                "userId": 4,
                "firstName": "Janaya",
                "lastName": "Klosges",
                "emailAddress": "jklosges3@amazon.de",
                "gender": "Female",
                "phoneNumber": "502-438-7799"
            }, {
                "userId": 5,
                "firstName": "Freddi",
                "lastName": "Di Claudio",
                "emailAddress": "fdiclaudio4@phoca.cz",
                "gender": "Female",
                "phoneNumber": "265-448-9627"
            }, {
                "userId": 6,
                "firstName": "Oliy",
                "lastName": "Mairs",
                "emailAddress": "omairs5@fda.gov",
                "gender": "Female",
                "phoneNumber": "221-516-2295"
            }, {
                "userId": 7,
                "firstName": "Tabb",
                "lastName": "Wiseman",
                "emailAddress": "twiseman6@friendfeed.com",
                "gender": "Male",
                "phoneNumber": "171-817-5020"
            }, {
                "userId": 8,
                "firstName": "Joela",
                "lastName": "Betteriss",
                "emailAddress": "jbetteriss7@msu.edu",
                "gender": "Female",
                "phoneNumber": "481-100-9345"
            }, {
                "userId": 9,
                "firstName": "Alistair",
                "lastName": "Vasyagin",
                "emailAddress": "avasyagin8@gnu.org",
                "gender": "Male",
                "phoneNumber": "520-669-8364"
            }, {
                "userId": 10,
                "firstName": "Nealon",
                "lastName": "Ratray",
                "emailAddress": "nratray9@typepad.com",
                "gender": "Male",
                "phoneNumber": "993-654-9793"
            }, {
                "userId": 11,
                "firstName": "Annissa",
                "lastName": "Kissick",
                "emailAddress": "akissicka@deliciousdays.com",
                "gender": "Female",
                "phoneNumber": "283-425-2705"
            }, {
                "userId": 12,
                "firstName": "Nissie",
                "lastName": "Sidnell",
                "emailAddress": "nsidnellb@freewebs.com",
                "gender": "Female",
                "phoneNumber": "754-391-3116"
            }, {
                "userId": 13,
                "firstName": "Madalena",
                "lastName": "Fouch",
                "emailAddress": "mfouchc@mozilla.org",
                "gender": "Female",
                "phoneNumber": "584-300-9004"
            }, {
                "userId": 14,
                "firstName": "Rozina",
                "lastName": "Atkins",
                "emailAddress": "ratkinsd@japanpost.jp",
                "gender": "Female",
                "phoneNumber": "792-856-0845"
            }, {
                "userId": 15,
                "firstName": "Lorelle",
                "lastName": "Sandcroft",
                "emailAddress": "lsandcrofte@google.nl",
                "gender": "Female",
                "phoneNumber": "882-911-7241"
            }],
            selectedRows: [],

            open: false,

            toggleColumn(key) {
                // Note: All td must have the same class name as the headings key! 
                let columns = document.querySelectorAll('.' + key);

                if (this.$refs[key].classList.contains('hidden') && this.$refs[key].classList.contains(key)) {
                    columns.forEach(column => {
                        column.classList.remove('hidden');
                    });
                } else {
                    columns.forEach(column => {
                        column.classList.add('hidden');
                    });
                }
            },

            getRowDetail($event, id) {
                let rows = this.selectedRows;

                if (rows.includes(id)) {
                    let index = rows.indexOf(id);
                    rows.splice(index, 1);
                } else {
                    rows.push(id);
                }
            },

            selectAllCheckbox($event) {
                let columns = document.querySelectorAll('.rowCheckbox');

                this.selectedRows = [];

                if ($event.target.checked == true) {
                    columns.forEach(column => {
                        column.checked = true
                        this.selectedRows.push(parseInt(column.name))
                    });
                } else {
                    columns.forEach(column => {
                        column.checked = false
                    });
                    this.selectedRows = [];
                }
            }
        }
    }
</script>
@endsection