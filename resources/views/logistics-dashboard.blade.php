<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logistics Management System</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandNav: '#1e293b',
                        brandBg: '#f1f5f9',
                        brandPurple: '#6366f1',
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome Library for high-fidelity icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar to match premium look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); opacity: 0.2; }
            50% { transform: scale(1.5); opacity: 0.8; }
        }
        .pulse-ring {
            animation: pulse-slow 3s infinite ease-in-out;
        }
    </style>
</head>
<body class="bg-brandBg font-sans text-slate-800 antialiased">

    <!-- TOAST ALERT PANEL -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 space-y-2 pointer-events-none"></div>

    <!-- INTERACTIVE SIMULATED CALL DIALER OVERLAY -->
    <div id="simulated-call-overlay" class="fixed inset-0 z-50 bg-slate-900/65 backdrop-blur-sm flex items-center justify-center hidden">
        <div class="bg-[#111827] text-white w-80 p-8 rounded-3xl shadow-2xl border border-slate-800 text-center flex flex-col items-center space-y-6 transform scale-95 transition-all duration-300">
            <div class="relative flex items-center justify-center">
                <div class="absolute w-28 h-28 bg-indigo-500/20 rounded-full animate-ping"></div>
                <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center text-3xl border border-indigo-400">
                    <i class="fa-solid fa-user-astronaut text-white"></i>
                </div>
            </div>
            <div>
                <h3 id="call-driver-name" class="text-xl font-bold">Erich De Torres</h3>
                <p id="call-status-label" class="text-xs text-indigo-400 font-semibold tracking-wider uppercase mt-1">DIALING...</p>
                <p id="call-timer" class="text-sm text-slate-400 font-mono mt-2 hidden">00:00</p>
            </div>
            <div class="flex items-center gap-6">
                <button class="w-11 h-11 bg-slate-800 hover:bg-slate-700 rounded-full flex items-center justify-center text-slate-300 transition-all active:scale-90"><i class="fa-solid fa-microphone-slash"></i></button>
                <button onclick="hangUpSimulatedCall()" class="w-14 h-14 bg-red-600 hover:bg-red-500 rounded-full flex items-center justify-center text-white text-xl shadow-lg shadow-red-600/30 transition-all active:scale-90"><i class="fa-solid fa-phone-slash"></i></button>
                <button class="w-11 h-11 bg-slate-800 hover:bg-slate-700 rounded-full flex items-center justify-center text-slate-300 transition-all active:scale-90"><i class="fa-solid fa-volume-high"></i></button>
            </div>
        </div>
    </div>

    <!-- FLOATING LIVE DRIVER SIMULATED CHAT WINDOW -->
    <div id="simulated-chat-window" class="fixed bottom-6 right-6 w-80 bg-white rounded-2xl shadow-2xl border border-slate-200/80 z-50 flex flex-col hidden overflow-hidden transition-all duration-300 transform translate-y-4 opacity-0">
        <div class="bg-[#1a2342] text-white p-4 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-sm font-bold text-white"><i class="fa-solid fa-circle-user"></i></div>
                <div>
                    <h4 id="chat-driver-name" class="text-xs font-bold">Erich De Torres</h4>
                    <span class="text-[9px] text-emerald-400 flex items-center gap-1 font-semibold"><span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Driver Status: Active</span>
                </div>
            </div>
            <button onclick="closeDriverChat()" class="text-slate-300 hover:text-white transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div id="chat-messages-container" class="p-4 h-64 overflow-y-auto space-y-3 bg-slate-50 text-xs flex flex-col"></div>
        <div class="p-3 border-t border-slate-100 flex items-center gap-2 bg-white">
            <input id="chat-text-input" onkeydown="handleChatEnterKey(event)" type="text" placeholder="Type a message..." class="flex-1 px-3 py-1.5 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
            <button onclick="sendDriverChatMessage()" class="w-8 h-8 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 active:scale-95 transition-all"><i class="fa-solid fa-paper-plane text-xs"></i></button>
        </div>
    </div>

    <!-- SLIDE-IN ADVANCED FILTER SIDEBAR DRAWER -->
    <div id="filter-sidebar-drawer" class="fixed inset-y-0 right-0 z-50 w-80 bg-white shadow-2xl border-l border-slate-200 flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-sliders text-indigo-600"></i> Advanced Filtering
            </h3>
            <button onclick="toggleFilterSidebar(false)" class="text-slate-400 hover:text-slate-600 transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="p-6 flex-1 overflow-y-auto space-y-6 text-xs font-semibold text-slate-600">
            <!-- Filter by City Segment -->
            <div class="space-y-2">
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-bold">Filter By City Hub</span>
                <div class="space-y-2 font-medium text-slate-700">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="filter-city-cavite" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" checked> Cavite</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="filter-city-laguna" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" checked> Laguna</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="filter-city-manila" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" checked> Manila</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="filter-city-bulacan" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" checked> Bulacan</label>
                </div>
            </div>
            <!-- Filter by Shipment Status Segment -->
            <div class="space-y-2">
                <span class="block text-[10px] text-slate-400 uppercase tracking-wider font-bold">Filter By Status</span>
                <div class="space-y-2 font-medium text-slate-700">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="filter-status-route" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" checked> En Route</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="filter-status-delayed" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" checked> Delayed</label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" id="filter-status-delivered" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" checked> Delivered</label>
                </div>
            </div>
        </div>
        <div class="p-4 border-t border-slate-100 flex gap-2 bg-slate-50">
            <button onclick="resetFilters()" class="flex-1 py-2 border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition active:scale-95">Reset</button>
            <button onclick="applyFilters()" class="flex-1 py-2 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition active:scale-95 shadow-lg shadow-indigo-600/20">Apply Filters</button>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR NAVIGATION -->
        <aside id="main-sidebar" class="w-64 bg-[#1a2342] text-slate-300 flex flex-col flex-shrink-0 transition-all duration-200">
            <div class="p-6 flex items-center gap-3 border-b border-slate-700">
                <div class="p-2 bg-slate-700 rounded-lg">
                    <i class="fa-solid fa-truck text-white text-xl"></i>
                </div>
                <span class="text-xl font-bold text-white tracking-wide">Logistics</span>
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <button onclick="switchTab('dashboard')" id="btn-dashboard" class="nav-link w-full flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium text-left">
                    <i class="fa-solid fa-chart-pie text-lg"></i> Dashboard
                </button>
                <button onclick="switchTab('tracking')" id="btn-tracking" class="nav-link w-full flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium text-left">
                    <i class="fa-solid fa-location-dot text-lg"></i> Shipment Tracking
                </button>
                <button onclick="switchTab('schedules')" id="btn-schedules" class="nav-link w-full flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium text-left">
                    <i class="fa-solid fa-calendar-days text-lg"></i> Delivery Schedules
                </button>
                <button onclick="switchTab('status')" id="btn-status" class="nav-link w-full flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 font-medium text-left">
                    <i class="fa-solid fa-bell text-lg"></i> Shipment Status
                </button>

                <!-- LINK BACK TO MAIN DASHBOARD / PAGES.DASHBOARD -->
                <div class="pt-4 mt-4 border-t border-slate-700/60">
                    @if(Route::has('dashboard'))
                        <a href="{{ route('dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-300 hover:text-white hover:bg-indigo-600/30 transition duration-200 font-bold text-left text-xs bg-indigo-950/40 border border-indigo-500/20">
                            <i class="fa-solid fa-house text-indigo-400 text-sm"></i> Back to Main Home
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-300 hover:text-white hover:bg-indigo-600/30 transition duration-200 font-bold text-left text-xs bg-indigo-950/40 border border-indigo-500/20">
                            <i class="fa-solid fa-house text-indigo-400 text-sm"></i> Back to Main Home
                        </a>
                    @endif
                </div>
            </nav>
        </aside>

        <!-- MAIN WINDOW WRAPPER -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-[#eef2f6]">
            
            <!-- GLOBAL REUSABLE SEARCH HEADER -->
            <header id="main-header" class="bg-white px-8 py-4 flex items-center justify-between border-b border-slate-200 shadow-sm sticky top-0 z-30">
                <div>
                    <h1 id="page-title" class="text-2xl font-bold text-slate-800">Dashboard</h1>
                    <p id="page-desc" class="text-xs text-slate-500 mt-0.5">Monitor your shipments and logistics in real-time</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative flex items-center">
                        <input id="global-search-input" onkeyup="globalSearchEngine()" type="text" placeholder="Search everywhere..." class="pl-9 pr-10 py-1.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 text-slate-400 text-sm"></i>
                        <button onclick="globalSearchEngine()" class="absolute right-2.5 text-slate-400 hover:text-indigo-600 transition">
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                    <button onclick="toggleFilterSidebar(true)" class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 flex items-center gap-1.5">
                        <i class="fa-solid fa-sliders text-xs"></i> Filter
                    </button>
                    <button id="btn-download-report" onclick="triggerReportDownload()" class="px-3 py-1.5 bg-slate-800 text-white text-sm font-medium rounded-lg hover:bg-slate-700 flex items-center gap-1.5 shadow-sm active:scale-95 transition-all">
                        <i class="fa-solid fa-download text-xs"></i> Download report
                    </button>
                    <!-- Trigger button to register new shipment -->
                    <button onclick="openModal('addModal')" class="px-3.5 py-1.5 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 flex items-center gap-1.5 shadow-md shadow-indigo-600/20 active:scale-95 transition-all">
                        <i class="fa-solid fa-circle-plus text-xs"></i> Add Shipment
                    </button>
                </div>
            </header>

            <!-- TAB PAGES CONTAINER -->
            <div class="p-6 max-w-7xl w-full mx-auto flex-1">

                @if(session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <!-- 1. DASHBOARD TAB VIEW -->
                <div id="view-dashboard" class="tab-view space-y-6 hidden">
                    <!-- Metric Kpis Row -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Active Shipments</span>
                            <div class="text-3xl font-bold text-slate-800 mt-2">{{ $shipments->count() }}</div>
                            <span class="text-xs font-medium text-emerald-600 mt-1 inline-block">MySQL rows compiled</span>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Delayed</span>
                            <div class="text-3xl font-bold text-slate-800 mt-2">{{ $shipments->where('status', 'Delayed')->count() }}</div>
                            <span class="text-xs font-medium text-amber-600 mt-1 inline-block">Requires active response</span>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Fuel Efficiency</span>
                            <div class="text-3xl font-bold text-slate-800 mt-2">6.7<span class="text-base font-medium text-slate-500">km/L</span></div>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Delivery Budget</span>
                            <div class="text-3xl font-bold text-slate-800 mt-2">₱{{ number_format($shipments->sum('delivery_cost'), 2) }}</div>
                        </div>
                    </div>

                    <!-- Layout Segment Split Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <!-- Active Shipments Filter Box -->
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm lg:col-span-7 flex flex-col overflow-hidden">
                            <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                                <h3 class="font-bold text-slate-800 text-sm">Active Shipments</h3>
                                <div class="flex gap-1 text-xs bg-slate-100 p-1 rounded-lg">
                                    <button id="filter-all" onclick="filterDashboardShipments('all')" class="px-3 py-1 font-semibold rounded-md transition-all text-indigo-600 bg-white shadow-sm">All</button>
                                    <button id="filter-transit" onclick="filterDashboardShipments('transit')" class="px-3 py-1 font-medium rounded-md transition-all text-slate-500 hover:text-slate-800">In transit</button>
                                    <button id="filter-delayed" onclick="filterDashboardShipments('delayed')" class="px-3 py-1 font-medium rounded-md transition-all text-slate-500 hover:text-slate-800">Delayed</button>
                                    <button id="filter-delivered" onclick="filterDashboardShipments('delivered')" class="px-3 py-1 font-medium rounded-md transition-all text-slate-500 hover:text-slate-800">Delivered</button>
                                </div>
                            </div>
                            <div id="dashboard-shipment-list" class="divide-y divide-slate-100 flex-1 min-h-[300px]">
                                <!-- Injected dynamically using shipmentFilterData state -->
                            </div>
                        </div>

                        <!-- Map Preview click overlay block -->
                        <div onclick="openFullscreenMap()" class="bg-white rounded-2xl border border-slate-200 shadow-sm lg:col-span-5 relative h-80 lg:h-auto overflow-hidden min-h-[320px] cursor-pointer group">
                            <!-- HIGH-FIDELITY INLINE SVG MAP -->
                            <div class="absolute inset-0 bg-[#eef2f6] transition-transform duration-500 group-hover:scale-105">
                                <svg class="w-full h-full" viewBox="0 0 400 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="400" height="320" fill="#f1f5f9"/>
                                    <path d="M-20 -20 C 50 100, 150 140, 180 80 C 210 20, 250 -40, 200 -50 Z" fill="#d0e1fd" opacity="0.8"/>
                                    <text x="70" y="50" fill="#94a3b8" font-size="10" font-weight="600" letter-spacing="1">BACOOR BAY</text>
                                    
                                    <line x1="50" y1="0" x2="50" y2="320" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 4" />
                                    <line x1="150" y1="0" x2="150" y2="320" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 4" />
                                    <line x1="250" y1="0" x2="250" y2="320" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 4" />
                                    <line x1="350" y1="0" x2="350" y2="320" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 4" />

                                    <path d="M 30,120 Q 150,150 250,130 T 380,240" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M 30,120 Q 150,150 250,130 T 380,240" stroke="#cbd5e1" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M 30,120 Q 150,150 250,130 T 380,240" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="4 6"/>

                                    <path d="M 30,120 C 100,50 200,40 280,80 T 380,240" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M 30,120 C 100,50 200,40 280,80 T 380,240" stroke="#3b82f6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>

                                    <text x="28" y="110" fill="#334155" font-size="9" font-weight="700">Cavite</text>
                                    <text x="240" y="75" fill="#334155" font-size="10" font-weight="700">Taguig</text>
                                    <text x="180" y="180" fill="#334155" font-size="10" font-weight="700">Imus</text>

                                    <g transform="translate(140, 85)">
                                        <circle cx="0" cy="0" r="12" fill="#3b82f6" class="pulse-ring" />
                                        <circle cx="0" cy="0" r="5" fill="#2563eb" stroke="#ffffff" stroke-width="1.5" />
                                    </g>
                                    <g transform="translate(320, 180)">
                                        <circle cx="0" cy="0" r="12" fill="#a855f7" class="pulse-ring" />
                                        <circle cx="0" cy="0" r="5" fill="#7c3aed" stroke="#ffffff" stroke-width="1.5" />
                                    </g>
                                </svg>
                            </div>
                            <div class="absolute inset-0 bg-black/5 flex flex-col justify-between p-4 z-10">
                                <button class="self-start px-3 py-1 bg-white/95 backdrop-blur rounded-lg text-xs font-bold shadow-md text-slate-700 flex items-center gap-1.5">
                                    Maps Preview <i class="fa-solid fa-magnifying-glass-plus text-[10px] text-indigo-600"></i>
                                </button>
                                <div class="bg-[#1a2342]/90 backdrop-blur-md px-3 py-2 rounded-xl shadow-lg text-center text-[11px] font-bold text-white border border-white/15 mt-auto self-center">
                                    Click to view interactive telemetry map (image_23866b.jpg)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom stats detail rows -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm lg:col-span-6">
                            <h3 class="font-bold text-slate-800 text-sm mb-4">Fleet Fuel Efficiency</h3>
                            <div class="h-44 bg-slate-50 rounded-xl flex items-end p-4 justify-between relative border border-slate-100">
                                <div class="w-1/4 h-[40%] bg-indigo-400/20 rounded-t mx-2 border-t-2 border-indigo-500 z-10 flex items-center justify-center text-[10px] text-indigo-700 font-bold">Vehicle 1</div>
                                <div class="w-1/4 h-[65%] bg-sky-400/20 rounded-t mx-2 border-t-2 border-sky-500 z-10 flex items-center justify-center text-[10px] text-sky-700 font-bold">Vehicle 2</div>
                                <div class="w-1/4 h-[30%] bg-emerald-400/20 rounded-t mx-2 border-t-2 border-emerald-500 z-10 flex items-center justify-center text-[10px] text-emerald-700 font-bold">Vehicle 3</div>
                                <div class="w-1/4 h-[80%] bg-amber-400/20 rounded-t mx-2 border-t-2 border-amber-500 z-10 flex items-center justify-center text-[10px] text-amber-700 font-bold">Vehicle 4</div>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm lg:col-span-3">
                            <h3 class="font-bold text-slate-800 text-sm mb-4">Shipment by City</h3>
                            <div class="space-y-2.5">
                                <div class="flex items-center justify-between p-2 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-xs font-medium text-slate-600 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Cavite</span>
                                    <span class="text-xs font-bold text-slate-700">89%</span>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-xs font-medium text-slate-600 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Laguna</span>
                                    <span class="text-xs font-bold text-slate-700">78%</span>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-xs font-medium text-slate-600 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Batangas</span>
                                    <span class="text-xs font-bold text-slate-700">51%</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm lg:col-span-3">
                            <h3 class="font-bold text-slate-800 text-sm mb-4">Driver Status</h3>
                            <div class="flex items-center justify-between gap-2">
                                <div class="relative w-24 h-24 rounded-full border-[10px] border-emerald-500 flex flex-col justify-center items-center">
                                    <span class="text-xl font-bold text-slate-800">100</span>
                                    <span class="text-[8px] text-slate-400 font-bold uppercase tracking-wider">Drivers</span>
                                </div>
                                <div class="text-[11px] font-medium text-slate-600 space-y-1.5 flex-1">
                                    <div class="flex justify-between items-center pl-2 border-l-2 border-emerald-500"><span>On Route</span><strong>83</strong></div>
                                    <div class="flex justify-between items-center pl-2 border-l-2 border-amber-400"><span>Available</span><strong>11</strong></div>
                                    <div class="flex justify-between items-center pl-2 border-l-2 border-slate-300"><span>Off Shift</span><strong>6</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. SHIPMENT TRACKING TAB VIEW -->
                <div id="view-tracking" class="tab-view grid grid-cols-1 lg:grid-cols-12 gap-6 hidden">
                    <div class="lg:col-span-5 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1 flex items-center">
                                <input id="tracking-search-input" onkeyup="searchTrackers()" type="text" placeholder="Enter shipment ID..." class="w-full pl-9 pr-8 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 text-slate-400 text-xs"></i>
                                <button onclick="searchTrackers()" class="absolute right-3 text-slate-400 hover:text-indigo-600 transition">
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                            <button onclick="toggleFilterSidebar(true)" class="w-9 h-9 border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-indigo-600 transition duration-150" title="Open Filter Options">
                                <i class="fa-solid fa-filter text-xs"></i>
                            </button>
                        </div>
                        
                        <!-- Trackers List Cards -->
                        <div id="tracking-cards-deck" class="space-y-3 max-h-[500px] overflow-y-auto pr-1">
                            @foreach($shipments as $s)
                            @php
                                $trackingKey = str_replace(' - ', '-', $s->shipment_code);
                                $progressClass = $s->status === 'Delivered' ? 'w-full bg-emerald-500' : ($s->status === 'Delayed' ? 'w-1/3 bg-rose-500' : 'w-2/3 bg-orange-400');
                                $pillClass = $s->status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : ($s->status === 'Delayed' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700');
                            @endphp
                            <div id="card-track-{{ $trackingKey }}" class="tracking-card p-4 rounded-xl border border-slate-200 hover:border-indigo-300 cursor-pointer transition-all bg-slate-50/50">
                                <div onclick="selectTrackingOrder('{{ $trackingKey }}')" class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-slate-800">#{{ $s->shipment_code }}</span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $pillClass }}">{{ $s->status }}</span>
                                    </div>
                                    <div class="h-1 bg-slate-200 rounded relative my-3">
                                        <div class="absolute top-0 left-0 h-full {{ $progressClass }} rounded"></div>
                                    </div>
                                    <div class="flex items-center justify-between text-[11px] text-slate-400 font-semibold">
                                        <span>{{ explode(' - ', $s->route_path)[0] ?? 'Cavite' }}</span> <span>{{ explode(' - ', $s->route_path)[1] ?? 'Laguna' }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center pt-3 border-t border-slate-100 text-xs mt-3">
                                    <div>
                                        <p class="font-bold text-slate-700">{{ $s->driver_name }}</p>
                                        <p class="text-slate-400 text-[10px]">JNT EXPRESS</p>
                                    </div>
                                    <div class="flex gap-1.5 z-20">
                                        <button onclick="openDriverChat('{{ $s->driver_name }}')" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 flex items-center justify-center transition"><i class="fa-solid fa-comment-dots text-xs"></i></button>
                                        <button onclick="initiateSimulatedCall('{{ $s->driver_name }}')" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 flex items-center justify-center transition"><i class="fa-solid fa-phone text-xs"></i></button>
                                        <button onclick="openEditModal({{ json_encode($s) }})" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 flex items-center justify-center transition" title="Modify Record"><i class="fa-solid fa-pencil text-xs"></i></button>
                                        <form action="{{ route('shipments.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Sigurado ka bang burahin si {{ $s->driver_name }} sa database?')" class="inline m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 text-rose-600 hover:text-white hover:bg-rose-500 flex items-center justify-center transition" title="Delete Record"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Map Panel with the popups -->
                    <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 overflow-hidden min-h-[480px] relative shadow-sm">
                        <div class="absolute inset-0 bg-[#0f172a]">
                            <svg class="w-full h-full" viewBox="0 0 500 480" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M 50,-50 C 180,20 320,60 380,-10 C 420,-60 550,50 480,180 C 410,310 250,220 180,280 C 110,340 -50,240 -20,100 Z" fill="#1e293b" opacity="0.6"/>
                                <path d="M 280,100 C 340,120 400,80 450,150 C 420,220 350,180 280,100 Z" fill="#0f172a" opacity="0.4"/>
                                <path d="M 10,240 Q 150,220 280,290 T 480,330" stroke="#334155" stroke-width="8" stroke-linecap="round"/>
                                <path d="M 10,240 Q 150,220 280,290 T 480,330" stroke="#475569" stroke-width="4" stroke-linecap="round"/>
                                <path d="M 10,240 Q 150,220 280,290 T 480,330" stroke="#3b82f6" stroke-width="2" stroke-linecap="round"/>
                                <path d="M 50,420 C 120,380 220,350 310,400 T 450,330" stroke="#1e293b" stroke-width="12" stroke-linecap="round"/>
                                <path d="M 50,420 C 120,380 220,350 310,400 T 450,330" stroke="#10b981" stroke-width="6" stroke-linecap="round"/>
                                <line x1="120" y1="200" x2="310" y2="400" stroke="#334155" stroke-width="3" stroke-dasharray="3 5" />
                                <line x1="280" y1="290" x2="280" y2="100" stroke="#334155" stroke-width="2" />
                                <text x="180" y="120" fill="#94a3b8" font-size="16" font-weight="800" opacity="0.5" letter-spacing="1">Los Baños</text>
                                <text x="320" y="240" fill="#64748b" font-size="12" font-weight="700">Calauan</text>
                                <text x="180" y="380" fill="#64748b" font-size="12" font-weight="700">Alaminos</text>
                                <text x="340" y="30" fill="#475569" font-size="14" font-weight="800">Bay</text>
                                <g transform="translate(450, 330)">
                                    <circle cx="0" cy="0" r="16" fill="#ef4444" class="pulse-ring" />
                                    <circle cx="0" cy="0" r="7" fill="#dc2626" stroke="#ffffff" stroke-width="2" />
                                    <path d="M -4,-18 L 4,-18 L 0,-10 Z" fill="#dc2626"/>
                                </g>
                            </svg>
                        </div>
                        
                        <div class="absolute top-4 left-4 bg-blue-600 text-white font-bold px-3 py-1.5 rounded-lg text-xs z-10 shadow-md">
                            1 hr 29 min <span class="block text-[10px] opacity-85 font-normal">Fastest Route</span>
                        </div>

                        <div id="tracking-timeline-overlay" class="absolute top-12 right-12 w-64 bg-white/95 backdrop-blur rounded-2xl shadow-xl border border-slate-200/80 p-4 space-y-3 z-20 hidden">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <div>
                                    <h4 id="overlay-driver-name" class="font-bold text-xs text-slate-800">Erich De Torres</h4>
                                    <span id="overlay-carrier-label" class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">JNT EXPRESS</span>
                                </div>
                                <div class="flex gap-1 z-30">
                                    <button onclick="openDriverChat(document.getElementById('overlay-driver-name').innerText)" class="w-6 h-6 rounded bg-slate-100 text-slate-600 hover:text-indigo-600 flex items-center justify-center transition"><i class="fa-solid fa-comment-dots text-[10px]"></i></button>
                                    <button onclick="initiateSimulatedCall(document.getElementById('overlay-driver-name').innerText)" class="w-6 h-6 rounded bg-slate-100 text-slate-600 hover:text-indigo-600 flex items-center justify-center transition"><i class="fa-solid fa-phone text-[10px]"></i></button>
                                </div>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Shipment ID</span>
                                <span id="overlay-shipment-id" class="text-xs font-bold text-slate-700">#ABC - 01234</span>
                            </div>
                            <div class="space-y-3 relative pl-3 border-l border-slate-200 ml-1.5 pt-1 text-[11px]" id="overlay-timeline-container">
                                <!-- Inner logs built dynamically -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. DELIVERY SCHEDULES TAB VIEW -->
                <div id="view-schedules" class="tab-view grid grid-cols-1 lg:grid-cols-12 gap-6 hidden">
                    <div class="lg:col-span-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <input id="schedule-search-input" onkeyup="searchSchedulesDrivers()" type="text" placeholder="Enter shipment ID..." class="w-full pl-9 pr-3 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Drivers dispatch loop from MySQL -->
                        <div id="schedule-drivers-list" class="divide-y divide-slate-100 max-h-[180px] overflow-y-auto pr-1">
                            @foreach($shipments as $s)
                            <div class="py-2 flex items-center justify-between text-xs schedule-driver-row">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-user text-slate-400"></i>
                                    <div><p class="font-bold text-slate-800">{{ $s->driver_name }}</p><p class="text-[10px] text-slate-400">#{{ $s->shipment_code }}</p></div>
                                </div>
                                <button onclick="triggerScheduleLayoutOverview('{{ str_replace(' - ', '-', $s->shipment_code) }}')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 font-semibold rounded transition text-[11px]">See order</button>
                            </div>
                            @endforeach
                        </div>

                        <!-- Schedules Category List -->
                        <div class="space-y-1.5 pt-2 border-t border-slate-100">
                            <button id="sched-btn-paid" onclick="switchScheduleList('paid')" class="sched-cat-btn w-full text-left p-2.5 rounded-xl border border-slate-200 font-bold text-slate-700 text-xs flex justify-between items-center transition">
                                <span class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> PAID</span> 
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-semibold">See List</span>
                            </button>
                            <button id="sched-btn-pendings" onclick="switchScheduleList('pendings')" class="sched-cat-btn w-full text-left p-2.5 rounded-xl border border-slate-200 font-bold text-slate-700 text-xs flex justify-between items-center transition">
                                <span class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> PENDINGS</span> 
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-semibold">See List</span>
                            </button>
                            <button id="sched-btn-cod" onclick="switchScheduleList('cod')" class="sched-cat-btn w-full text-left p-2.5 rounded-xl border border-slate-200 font-bold text-slate-700 text-xs flex justify-between items-center transition">
                                <span class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> CASH ON DELIVERY</span> 
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-semibold">See List</span>
                            </button>
                            <button id="sched-btn-transit" onclick="switchScheduleList('transit')" class="sched-cat-btn w-full text-left p-2.5 rounded-xl border border-slate-200 font-bold text-slate-700 text-xs flex justify-between items-center transition">
                                <span class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-teal-400"></span> IN TRANSIT</span> 
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-semibold">See List</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right Display Split Panel -->
                    <div class="lg:col-span-8 flex flex-col space-y-4">
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-64">
                            <div class="p-3 bg-slate-50 border-b border-slate-100 font-bold text-xs text-slate-700 flex items-center justify-between">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-list-check"></i> Delivery Schedule Log Ledger</span>
                            </div>
                            <div class="overflow-y-auto flex-1 text-[11px]">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-slate-100 text-slate-500 font-bold border-b border-slate-200 sticky top-0">
                                        <tr>
                                            <th class="p-2 pl-3">Day/Date</th>
                                            <th class="p-2">Order Code</th>
                                            <th class="p-2">Driver Name</th>
                                            <th class="p-2">Details</th>
                                            <th class="p-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                                        @foreach($shipments as $s)
                                        <tr>
                                            <td class="p-2 pl-3">Mon 13/09/26</td>
                                            <td class="p-2">#{{ $s->shipment_code }}</td>
                                            <td class="p-2">{{ $s->driver_name }}</td>
                                            <td class="p-2">{{ $s->cargo_details }}</td>
                                            <td class="p-2">
                                                <span class="px-2 py-0.5 rounded font-bold text-[9px] {{ $s->status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                    {{ $s->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Category subtable switches content via JS templates -->
                        <div id="schedule-subtable-box" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex-1 min-h-[240px]"></div>
                    </div>
                </div>

                <!-- 4. SHIPMENT STATUS TAB VIEW -->
                <div id="view-status" class="tab-view grid grid-cols-1 lg:grid-cols-12 gap-6 hidden relative">
                    <!-- CANCEL ORDER QUESTION OVERLAY PANEL -->
                    <div id="status-cancel-confirm-overlay" class="hidden absolute inset-0 bg-white/95 backdrop-blur z-30 flex flex-col justify-center items-center text-center p-8 rounded-2xl">
                        <div class="p-4 bg-rose-50 text-rose-600 rounded-full text-3xl mb-4 animate-bounce">
                            <i class="fa-solid fa-circle-question"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Are you sure you want to cancel?</h3>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm">This action will halt active GPS routes, dispatch sequences, and delivery records for the current shipment ID.</p>
                        <div class="flex items-center gap-3 mt-6">
                            <button onclick="confirmCancellationAction(true)" class="px-6 py-2 bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs rounded-xl shadow transition active:scale-95">Yes, Cancel</button>
                            <button onclick="confirmCancellationAction(false)" class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-xl transition active:scale-95">No, Return</button>
                        </div>
                    </div>

                    <!-- Left Status Panel -->
                    <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-5 relative overflow-hidden">
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span id="status-order-code" class="text-base font-bold text-slate-800"># ABC - 01234</span>
                                <span class="px-2.5 py-0.5 bg-blue-500 text-white text-[10px] font-bold rounded-full shadow-sm">In progress</span>
                            </div>
                            <div class="flex gap-1.5">
                                <button onclick="prevStatusOrder()" class="w-7 h-7 bg-slate-100 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-lg flex items-center justify-center text-xs text-slate-600 hover:text-indigo-600 font-bold transition">&lt;</button>
                                <button onclick="nextStatusOrder()" class="w-7 h-7 bg-slate-100 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-lg flex items-center justify-center text-xs text-slate-600 hover:text-indigo-600 font-bold transition">&gt;</button>
                            </div>
                        </div>

                        <div class="text-[11px] text-slate-400 font-medium flex justify-between items-center border-b border-slate-100 pb-2">
                            <div>Shipping Date: <span id="status-shipping-date" class="text-slate-700 font-bold">September 11, 2026</span></div>
                            <div>Order ID: <span id="status-order-id" class="text-slate-700 font-bold">1234</span></div>
                        </div>

                        <div class="flex justify-between items-center">
                            <button onclick="promptCancellation()" class="text-rose-600 font-bold hover:underline text-xs flex items-center gap-1 active:scale-95 transition-all">
                                <i class="fa-solid fa-ban"></i> Cancel Order
                            </button>
                            <div class="flex gap-2">
                                <button onclick="initiateSimulatedCall('Erich De Torres')" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:text-indigo-600 flex items-center justify-center transition"><i class="fa-solid fa-phone text-xs"></i></button>
                                <button onclick="triggerCustomerNotification()" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-lg transition shadow-sm active:scale-95">Notify Customer</button>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/60 space-y-2.5 text-xs">
                            <div class="flex items-start gap-2 text-slate-600">
                                <i class="fa-solid fa-circle-dot mt-1 text-indigo-500"></i> 
                                <div><strong>Origin Address:</strong> <p id="status-origin" class="text-slate-700 mt-0.5">2118 Ridge St. Cavite, 3564</p></div>
                            </div>
                            <div class="flex items-start gap-2 text-slate-600">
                                <i class="fa-solid fa-location-pin mt-1 text-rose-500"></i> 
                                <div><strong>Destination Address:</strong> <p id="status-destination" class="text-slate-700 mt-0.5">3517 W. Gray St. Utica, 5789</p></div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <div class="h-1 bg-slate-200 rounded relative">
                                <div id="status-progress-fill" class="absolute top-0 left-0 w-2/3 h-full bg-orange-400 rounded transition-all duration-300"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider pt-1">
                                <span>Departure</span>
                                <span>Sorting Center</span>
                                <span>Transit</span>
                                <span>Arrival</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-[10px] bg-slate-50 p-2.5 rounded-lg text-center font-medium">
                            <div><span class="text-slate-400 block">Total Time</span><strong id="status-duration" class="text-slate-800 text-[11px]">3 days, 5hrs</strong></div>
                            <div><span class="text-slate-400 block">Departure Time</span><strong id="status-dep-time" class="text-slate-800 text-[11px]">11 Sept 26 14:11 PM</strong></div>
                            <div><span class="text-slate-400 block">Expected Arrive</span><strong id="status-arr-time" class="text-slate-800 text-[11px]">13 Sept 26 17:18 PM</strong></div>
                        </div>

                        <div class="space-y-3 relative pl-6 border-l-2 border-indigo-500 ml-2 pt-1 text-xs">
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-indigo-500 border-4 border-white shadow"></span>
                                <div class="flex justify-between font-semibold text-slate-800">
                                    <div><p>Order Placed</p><p class="text-[10px] text-slate-400 font-normal">Shipment information received by seller</p><span class="text-[10px] font-bold text-slate-600 flex items-center gap-1 mt-0.5"><i class="fa-solid fa-location-dot text-indigo-500 text-[9px]"></i> Cavite City</span></div>
                                    <span class="text-[10px] text-slate-400">10 Sept 2026, 14:00 PM</span>
                                </div>
                            </div>
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-indigo-500 border-4 border-white shadow"></span>
                                <div class="flex justify-between text-slate-600 font-medium">
                                    <div><p>Preparing to ship</p><p class="text-[10px] text-slate-400 font-normal">Seller is preparing to ship your order</p></div>
                                    <span class="text-[10px]">10 Sept 2026, 20:00 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right map representing route visual -->
                    <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 overflow-hidden min-h-[480px] relative shadow-sm">
                        <div id="status-map-canvas" class="absolute inset-0 bg-[#e2f0d9]">
                            <svg class="w-full h-full" viewBox="0 0 500 480" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M-10,320 C100,280 180,330 200,450 C220,520 -10,500 -10,320 Z" fill="#b4dbb4" opacity="0.6"/>
                                <path d="M120,40 C210,10 320,80 340,150 C300,220 180,180 120,40 Z" fill="#b4dbb4" opacity="0.4"/>
                                <rect x="380" y="280" width="140" height="180" fill="#b4dbb4" opacity="0.5" rx="20"/>
                                <line x1="100" y1="0" x2="100" y2="480" stroke="#cfe2cf" stroke-width="1" stroke-dasharray="3 6"/>
                                <line x1="300" y1="0" x2="300" y2="480" stroke="#cfe2cf" stroke-width="1" stroke-dasharray="3 6"/>
                                <line x1="0" y1="150" x2="500" y2="150" stroke="#cfe2cf" stroke-width="1" stroke-dasharray="3 6"/>
                                <line x1="0" y1="350" x2="500" y2="350" stroke="#cfe2cf" stroke-width="1" stroke-dasharray="3 6"/>
                                <path d="M 280,180 L 290,110 L 305,230 L 285,320 L 400,310 L 440,360 L 485,390" stroke="#1e40af" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M 280,180 L 290,110 L 305,230 L 285,320 L 400,310 L 440,360 L 485,390" stroke="#3b82f6" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                                <g transform="translate(290, 110)"><circle cx="0" cy="0" r="10" fill="#2563eb" stroke="#ffffff" stroke-width="2"/><text x="-4" y="4" fill="#ffffff" font-size="10" font-weight="900">A</text></g>
                                <g transform="translate(305, 230)"><circle cx="0" cy="0" r="10" fill="#2563eb" stroke="#ffffff" stroke-width="2"/><text x="-4" y="4" fill="#ffffff" font-size="10" font-weight="900">B</text></g>
                                <g transform="translate(285, 320)"><circle cx="0" cy="0" r="10" fill="#2563eb" stroke="#ffffff" stroke-width="2"/><text x="-4" y="4" fill="#ffffff" font-size="10" font-weight="900">C</text></g>
                                <g transform="translate(440, 360)"><circle cx="0" cy="0" r="10" fill="#2563eb" stroke="#ffffff" stroke-width="2"/><text x="-4" y="4" fill="#ffffff" font-size="10" font-weight="900">D</text></g>
                                <rect x="305" y="145" width="14" height="14" rx="3" fill="#1e3a8a"/><text x="308" y="155" fill="#ffffff" font-size="8" font-weight="700">36</text>
                                <rect x="308" y="420" width="14" height="14" rx="3" fill="#1e3a8a"/><text x="311" y="430" fill="#ffffff" font-size="8" font-weight="700">23</text>
                                <text x="210" y="200" fill="#1e3a8a" font-size="12" font-weight="800">Palmerston</text>
                                <text x="210" y="360" fill="#047857" font-size="13" font-weight="800">Litchfield National Park</text>
                                <text x="370" y="110" fill="#475569" font-size="11" font-weight="700">Mount Bundey</text>
                                <text x="410" y="330" fill="#1e293b" font-size="10" font-weight="700">Adelaide River</text>
                            </svg>
                        </div>
                        <div class="absolute inset-0 bg-black/5 flex flex-col justify-between p-4 pointer-events-none">
                            <div class="flex justify-between items-start z-10">
                                <div class="bg-white/95 backdrop-blur p-2.5 rounded-xl text-[10px] font-bold text-slate-700 shadow-md border border-slate-200/50 space-y-0.5">
                                    <span class="text-indigo-600"><i class="fa-solid fa-route"></i> Live Telemetry View</span>
                                    <p class="text-slate-400 font-medium text-[9px]" id="status-map-label">Current Route: Cavite to Utica</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAP OVERLAY PANEL -->
                <div id="fullscreen-map-wrapper" class="hidden bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col space-y-4 p-4 shadow-sm animate-fade-in">
                    <div class="h-[380px] bg-slate-100 rounded-xl relative overflow-hidden border border-slate-200 shadow-inner">
                        <div class="absolute inset-0 bg-[#eef2f6]">
                            <svg class="w-full h-full" viewBox="0 0 1000 380" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="1000" height="380" fill="#f8fafc"/>
                                <path d="M-50 -50 C150,150 300,200 350,100 C400,0 450,-50 400,-100 Z" fill="#d0e1fd"/>
                                <text x="120" y="80" fill="#94a3b8" font-size="14" font-weight="700" letter-spacing="1">BACOOR BAY</text>
                                <line x1="200" y1="0" x2="200" y2="380" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 4"/>
                                <line x1="500" y1="0" x2="500" y2="380" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 4"/>
                                <line x1="800" y1="0" x2="800" y2="380" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 4"/>
                                <path d="M 100,200 C 250,150 450,180 600,100 T 900,280" stroke="#3b82f6" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M 100,200 Q 300,320 500,250 T 900,280" stroke="#e2e8f0" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M 100,200 Q 300,320 500,250 T 900,280" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="4 6"/>
                                <g transform="translate(100, 200)">
                                    <circle cx="0" cy="0" r="8" fill="#3b82f6" stroke="#ffffff" stroke-width="2"/>
                                    <text x="12" y="4" fill="#1e293b" font-size="10" font-weight="700">Cavite City</text>
                                </g>
                                <g transform="translate(600, 100)">
                                    <circle cx="0" cy="0" r="8" fill="#a855f7" stroke="#ffffff" stroke-width="2"/>
                                    <text x="12" y="4" fill="#1e293b" font-size="10" font-weight="700">Zapote Hub</text>
                                </g>
                                <g transform="translate(900, 280)">
                                    <circle cx="0" cy="0" r="8" fill="#10b981" stroke="#ffffff" stroke-width="2"/>
                                    <text x="-80" y="4" fill="#1e293b" font-size="10" font-weight="700">Laguna City</text>
                                </g>
                            </svg>
                        </div>
                        
                        <div class="absolute top-4 left-4 flex gap-2 z-10">
                            <div class="relative">
                                <input type="text" placeholder="Search shipments, destinations..." class="pl-8 pr-3 py-1.5 bg-white/95 backdrop-blur rounded-lg text-xs shadow focus:outline-none w-52 border border-slate-200">
                                <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-slate-400 text-[10px]"></i>
                            </div>
                            <button class="w-7 h-7 bg-white rounded shadow text-[11px] text-slate-600 flex items-center justify-center border border-slate-200"><i class="fa-solid fa-pencil"></i></button>
                            <button class="w-7 h-7 bg-white rounded shadow text-[11px] text-slate-600 flex items-center justify-center border border-slate-200"><i class="fa-solid fa-sliders"></i></button>
                        </div>

                        <div class="absolute top-1/4 left-1/3 bg-white/95 backdrop-blur p-2 rounded-lg shadow-lg text-[10px] font-bold text-slate-700 border border-slate-200">
                            <span class="text-rose-600 block"><i class="fa-solid fa-car"></i> 1 hr 7 min</span>
                            <span class="text-slate-400 font-medium text-[9px]">24.9 km</span>
                        </div>
                        <div class="absolute bottom-1/3 right-1/4 bg-white/95 backdrop-blur p-2 rounded-lg shadow-lg text-[10px] font-bold text-slate-700 border border-slate-200">
                            <span class="text-orange-600 block"><i class="fa-solid fa-motorcycle"></i> 1 hr 6 min</span>
                            <span class="text-slate-400 font-medium text-[9px]">24.8 km</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center pt-2">
                        <div class="md:col-span-4 p-3 bg-slate-50 border border-slate-200 rounded-xl flex flex-col justify-between">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-800">ORDER ID: #ABC-01234</span>
                                <i class="fa-solid fa-bars text-slate-400 text-[11px]"></i>
                            </div>
                            <div class="h-1 bg-slate-200 rounded my-3 relative">
                                <div class="absolute top-0 left-0 w-2/3 h-full bg-orange-400 rounded"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wide"><span>Cavite City</span><span>Laguna City</span></div>
                        </div>

                        <div class="md:col-span-4 p-3 bg-slate-50 border border-slate-200 rounded-xl flex flex-col justify-between">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-800">ORDER ID: #DEF-56789</span>
                                <i class="fa-solid fa-bars text-slate-400 text-[11px]"></i>
                            </div>
                            <div class="h-1 bg-slate-200 rounded my-3 relative">
                                <div class="absolute top-0 left-0 w-1/3 h-full bg-orange-400 rounded"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wide"><span>Cavite City</span><span>Laguna City</span></div>
                        </div>

                        <div class="md:col-span-4 flex flex-col sm:flex-row gap-3 justify-between items-stretch sm:items-center">
                            <div class="bg-slate-50 border border-slate-100 p-2 rounded-xl text-[11px] font-medium text-slate-600 space-y-1 flex-1">
                                <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-600"></span> Less Traffic</div>
                                <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-orange-500"></span> Heavy Traffic</div>
                            </div>
                            <button onclick="closeFullscreenMap()" class="px-5 py-3 bg-[#1a2342] hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition shadow-md whitespace-nowrap">
                                Back to Dashboard
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- INTERACTIVE MODAL: ADD SHIPMENT (MySQL INSERT) -->
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/85 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl p-6 transform scale-95 transition-all duration-300 max-h-[92vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3 mb-4">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-indigo-600"></i> Register New Shipment (MySQL INSERT)
                </h3>
                <button onclick="closeModal('addModal')" class="text-slate-400 hover:text-slate-600 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('shipments.store') }}" method="POST" class="space-y-4 text-xs font-semibold text-slate-600">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Shipment Code</label>
                        <input type="text" name="shipment_code" required placeholder="e.g. TRK-9908" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Driver Name</label>
                        <input type="text" name="driver_name" required placeholder="e.g. Gabriel Sotto" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Driver Phone Number</label>
                        <input type="text" name="phone_number" placeholder="e.g. +63 912 575 4567" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Estimated Arrival</label>
                        <input type="text" name="estimated_arrival" required placeholder="Arrives 15 Sept, 10:00" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Route Path</label>
                        <input type="text" name="route_path" required placeholder="e.g. Manila - Baguio" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="En Route">En Route</option>
                            <option value="Delayed">Delayed</option>
                            <option value="Delivered">Delivered</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Origin Address</label>
                        <input type="text" name="origin_address" required placeholder="Origin Depot City" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Destination Address</label>
                        <input type="text" name="destination_address" required placeholder="Destination Depot City" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Cargo Details / Items</label>
                        <input type="text" name="cargo_details" required placeholder="e.g. Vertex Mother Board Ryzen-5" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Delivery Cost (PHP)</label>
                        <input type="number" step="0.01" name="delivery_cost" required placeholder="e.g. 15000" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Quantity</label>
                        <input type="number" name="quantity" required placeholder="e.g. 10" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Payment Status</label>
                        <select name="payment_status" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                            <option value="COD">COD</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Category</label>
                        <select name="schedule_category" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="transit">Transit</option>
                            <option value="paid">Paid</option>
                            <option value="cod">COD</option>
                            <option value="pendings">Pending</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('addModal')" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-2 rounded-xl text-xs font-semibold transition-all">Cancel</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-xl text-xs font-semibold transition-all shadow-lg shadow-indigo-600/20">Insert Record</button>
                </div>
            </form>
        </div>
    </div>

    <!-- INTERACTIVE MODAL: EDIT SHIPMENT (MySQL UPDATE) -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/85 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl p-6 transform scale-95 transition-all duration-300 max-h-[92vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3 mb-4">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-600"></i> Modify Active Shipment (MySQL UPDATE)
                </h3>
                <button onclick="closeModal('editModal')" class="text-slate-400 hover:text-slate-600 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="editForm" method="POST" class="space-y-4 text-xs font-semibold text-slate-600">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Driver Name</label>
                    <input type="text" id="edit_driver_name" name="driver_name" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Driver Phone Number</label>
                        <input type="text" id="edit_phone_number" name="phone_number" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Route Path</label>
                        <input type="text" id="edit_route_path" name="route_path" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Estimated Arrival</label>
                        <input type="text" id="edit_estimated_arrival" name="estimated_arrival" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Delivery Cost (PHP)</label>
                        <input type="number" step="0.01" id="edit_delivery_cost" name="delivery_cost" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Origin Address</label>
                        <input type="text" id="edit_origin_address" name="origin_address" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Destination Address</label>
                        <input type="text" id="edit_destination_address" name="destination_address" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Cargo Details / Item Type</label>
                        <input type="text" id="edit_cargo_details" name="cargo_details" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Status</label>
                        <select id="edit_status" name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                            <option value="En Route">En Route</option>
                            <option value="Delayed">Delayed</option>
                            <option value="Delivered">Delivered</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Quantity</label>
                        <input type="number" id="edit_quantity" name="quantity" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Payment Status</label>
                        <select id="edit_payment_status" name="payment_status" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                            <option value="COD">COD</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-bold">Category</label>
                        <select id="edit_schedule_category" name="schedule_category" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                            <option value="transit">Transit</option>
                            <option value="paid">Paid</option>
                            <option value="cod">COD</option>
                            <option value="pendings">Pending</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('editModal')" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-2 rounded-xl text-xs font-semibold transition-all">Cancel</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2 rounded-xl text-xs font-semibold transition-all shadow-lg shadow-emerald-500/20">Apply Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT STATE LAYER -->
    <script>
        // Import dynamic server data dynamically
        const serverShipments = @json($shipments);

        // Convert the collection dynamically to fit the existing UI engine models
        const shipmentFilterData = {
            all: serverShipments.map(s => ({
                id: s.shipment_code,
                driver: s.driver_name,
                route: s.route_path,
                time: s.estimated_arrival,
                status: s.status,
                statusClass: s.status === 'Delivered' ? 'bg-emerald-100 text-emerald-800' : (s.status === 'Delayed' ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600'),
                dotClass: s.status === 'Delivered' ? 'bg-emerald-600' : (s.status === 'Delayed' ? 'bg-rose-500' : 'bg-emerald-500'),
                meta: s.meta_info || '4h 22m left',
                city: s.route_path.split(' - ')[0] || 'Cavite'
            })),
            transit: serverShipments.filter(s => s.status === 'En Route' || s.schedule_category === 'transit').map(s => ({
                id: s.shipment_code,
                driver: s.driver_name,
                route: s.route_path,
                time: s.estimated_arrival,
                status: s.status,
                statusClass: 'bg-emerald-50 text-emerald-600',
                dotClass: 'bg-emerald-500',
                meta: s.meta_info || '4h 22m left',
                city: s.route_path.split(' - ')[0] || 'Cavite'
            })),
            delayed: serverShipments.filter(s => s.status === 'Delayed').map(s => ({
                id: s.shipment_code,
                driver: s.driver_name,
                route: s.route_path,
                time: s.estimated_arrival,
                status: s.status,
                statusClass: 'bg-rose-50 text-rose-600',
                dotClass: 'bg-rose-500',
                meta: s.meta_info || '125h 00m left',
                city: s.route_path.split(' - ')[0] || 'Laguna'
            })),
            delivered: serverShipments.filter(s => s.status === 'Delivered').map(s => ({
                id: s.shipment_code,
                driver: s.driver_name,
                route: s.route_path,
                time: s.estimated_arrival,
                status: s.status,
                statusClass: 'bg-emerald-100 text-emerald-800',
                dotClass: 'bg-emerald-600',
                meta: '0h 00m left',
                city: s.route_path.split(' - ')[0] || 'Cavite'
            }))
        };

        const trackingOverlayDataset = {};
        serverShipments.forEach(s => {
            const key = s.shipment_code.replace(' - ', '-');
            trackingOverlayDataset[key] = {
                driver: s.driver_name,
                carrier: "JNT EXPRESS",
                id: '#' + s.shipment_code,
                timeline: [
                    { time: "10:20 AM", date: s.estimated_arrival, status: s.status, active: true },
                    { time: "09:15 AM", date: "12 Sept 2026", status: "In Transit", active: true },
                    { time: "06:21 AM", date: "11 Sept 2026", status: "In Sorting Centre", active: true },
                    { time: "07:24 AM", date: "10 Sept 2026", status: "Order Confirmed", active: true }
                ]
            };
        });

        const seeOrderDetailsMap = {};
        serverShipments.forEach(s => {
            const key = s.shipment_code.replace(' - ', '-');
            seeOrderDetailsMap[key] = {
                id: '#' + s.shipment_code,
                customerName: s.driver_name,
                address: s.destination_address || 'Laguna City, Philippines',
                phone: s.phone_number || '+63 912 575 4567',
                orderDetails: s.cargo_details || 'Vertex Mother Board Ryzen-5',
                qty: String(s.quantity || 1),
                paymentStatus: s.payment_status || 'Paid',
                cost: 'Php ' + Number(s.delivery_cost || 0).toLocaleString()
            };
        });

        const statusOrders = serverShipments.map(s => ({
            code: '# ' + s.shipment_code,
            shippingDate: "September 11, 2026",
            orderId: String(s.id),
            origin: s.origin_address || "Cavite Depot",
            destination: s.destination_address || "Laguna Depot",
            progressWidth: s.status === 'Delivered' ? "100%" : (s.status === 'Delayed' ? "33%" : "66%"),
            duration: s.meta_info || "3 days, 5hrs",
            depTime: "11 Sept 26 14:11 PM",
            arrTime: s.estimated_arrival,
            mapLabel: "Current Route: " + s.route_path
        }));

        let currentStatusIndex = 0;

        const scheduleSubTableTemplates = {
            paid: `
                <h4 class="font-bold text-xs text-slate-700 mb-3 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> List of Paid Orders</h4>
                <div class="overflow-x-auto text-[10px]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                            <tr><th class="p-2">Serial</th><th class="p-2">Client Name</th><th class="p-2">Route</th><th class="p-2">Operational Cost</th><th class="p-2">Status</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                            ${serverShipments.filter(s => s.payment_status === 'Paid').map((s, i) => `
                                <tr><td class="p-2">${i+1}</td><td class="p-2 font-bold">${s.driver_name}</td><td class="p-2">${s.route_path}</td><td class="p-2 text-emerald-600">₱${Number(s.delivery_cost).toLocaleString()}</td><td class="p-2 font-bold">${s.status}</td></tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `,
            pendings: `
                <h4 class="font-bold text-xs text-slate-700 mb-3 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-orange-400"></span> List of Pendings</h4>
                <div class="overflow-x-auto text-[10px]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                            <tr><th class="p-2">Serial</th><th class="p-2">Client Name</th><th class="p-2">Route</th><th class="p-2">Operational Cost</th><th class="p-2">Status</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                            ${serverShipments.filter(s => s.payment_status === 'Pending').map((s, i) => `
                                <tr><td class="p-2">${i+1}</td><td class="p-2 font-bold">${s.driver_name}</td><td class="p-2">${s.route_path}</td><td class="p-2 text-amber-600">₱${Number(s.delivery_cost).toLocaleString()}</td><td class="p-2 font-bold">${s.status}</td></tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `,
            cod: `
                <h4 class="font-bold text-xs text-slate-700 mb-3 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-400"></span> List of Cash on Deliveries</h4>
                <div class="overflow-x-auto text-[10px]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                            <tr><th class="p-2">Serial</th><th class="p-2">Client Name</th><th class="p-2">Route</th><th class="p-2">Operational Cost</th><th class="p-2">Status</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                            ${serverShipments.filter(s => s.payment_status === 'COD').map((s, i) => `
                                <tr><td class="p-2">${i+1}</td><td class="p-2 font-bold">${s.driver_name}</td><td class="p-2">${s.route_path}</td><td class="p-2 text-indigo-600">₱${Number(s.delivery_cost).toLocaleString()}</td><td class="p-2 font-bold">${s.status}</td></tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `,
            transit: `
                <h4 class="font-bold text-xs text-slate-700 mb-3 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-teal-400"></span> List of In transit</h4>
                <div class="overflow-x-auto text-[10px]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                            <tr><th class="p-2">Serial</th><th class="p-2">Client Name</th><th class="p-2">Route</th><th class="p-2">Operational Cost</th><th class="p-2">Status</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                            ${serverShipments.filter(s => s.status === 'En Route').map((s, i) => `
                                <tr><td class="p-2">${i+1}</td><td class="p-2 font-bold">${s.driver_name}</td><td class="p-2">${s.route_path}</td><td class="p-2 text-indigo-600">₱${Number(s.delivery_cost).toLocaleString()}</td><td class="p-2 font-bold">${s.status}</td></tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `
        };

        let callTimerInterval = null;
        let callSeconds = 0;

        function openModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('hidden');
                el.classList.add('flex');
            }
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('hidden');
                el.classList.remove('flex');
            }
        }

        function openEditModal(shipment) {
            document.getElementById('edit_driver_name').value = shipment.driver_name;
            document.getElementById('edit_phone_number').value = shipment.phone_number || '';
            document.getElementById('edit_route_path').value = shipment.route_path;
            document.getElementById('edit_estimated_arrival').value = shipment.estimated_arrival;
            document.getElementById('edit_delivery_cost').value = shipment.delivery_cost;
            document.getElementById('edit_status').value = shipment.status;
            
            // Populate additional parameters
            document.getElementById('edit_origin_address').value = shipment.origin_address || '';
            document.getElementById('edit_destination_address').value = shipment.destination_address || '';
            document.getElementById('edit_cargo_details').value = shipment.cargo_details || '';
            document.getElementById('edit_quantity').value = shipment.quantity || 1;
            document.getElementById('edit_payment_status').value = shipment.payment_status || 'Paid';
            document.getElementById('edit_schedule_category').value = shipment.schedule_category || 'transit';
            
            // Re-point the dynamic update URL 
            document.getElementById('editForm').action = "/shipments/" + shipment.id;
            
            openModal('editModal');
        }

        function toggleFilterSidebar(isOpen) {
            const drawer = document.getElementById('filter-sidebar-drawer');
            if (isOpen) {
                drawer.classList.remove('translate-x-full');
            } else {
                drawer.classList.add('translate-x-full');
            }
        }

        function resetFilters() {
            document.getElementById('filter-city-cavite').checked = true;
            document.getElementById('filter-city-laguna').checked = true;
            document.getElementById('filter-city-manila').checked = true;
            document.getElementById('filter-city-bulacan').checked = true;
            document.getElementById('filter-status-route').checked = true;
            document.getElementById('filter-status-delayed').checked = true;
            document.getElementById('filter-status-delivered').checked = true;
            applyFilters();
            showToastNotification("<i class='fa-solid fa-arrow-rotate-left mr-2'></i> Telemetry filters reset to default.");
        }

        function applyFilters() {
            const showCavite = document.getElementById('filter-city-cavite').checked;
            const showLaguna = document.getElementById('filter-city-laguna').checked;
            const showManila = document.getElementById('filter-city-manila').checked;
            const showBulacan = document.getElementById('filter-city-bulacan').checked;

            const showRoute = document.getElementById('filter-status-route').checked;
            const showDelayed = document.getElementById('filter-status-delayed').checked;
            const showDelivered = document.getElementById('filter-status-delivered').checked;

            const dashboardRows = document.querySelectorAll('#dashboard-shipment-list > div');
            dashboardRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                let matchesCity = false;
                let matchesStatus = false;

                if (showCavite && text.includes('cavite')) matchesCity = true;
                if (showLaguna && text.includes('laguna')) matchesCity = true;
                if (showManila && text.includes('manila')) matchesCity = true;
                if (showBulacan && text.includes('bulacan')) matchesCity = true;

                if (showRoute && text.includes('en route')) matchesStatus = true;
                if (showDelayed && text.includes('delayed')) matchesStatus = true;
                if (showDelivered && text.includes('delivered')) matchesStatus = true;

                if (matchesCity && matchesStatus) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });

            const trackingCards = document.querySelectorAll('.tracking-card');
            trackingCards.forEach(card => {
                const text = card.innerText.toLowerCase();
                let matchesCity = false;
                let matchesStatus = false;

                if (showCavite && text.includes('cavite')) matchesCity = true;
                if (showLaguna && text.includes('laguna')) matchesCity = true;
                if (showManila && text.includes('manila')) matchesCity = true;
                if (showBulacan && text.includes('bulacan')) matchesCity = true;

                if (showRoute && text.includes('transit')) matchesStatus = true;
                if (showDelayed && text.includes('delayed')) matchesStatus = true;
                if (showDelivered && text.includes('delivered')) matchesStatus = true;

                if (matchesCity && matchesStatus) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            toggleFilterSidebar(false);
            showToastNotification("<i class='fa-solid fa-filter mr-2 text-indigo-400'></i> Advanced telemetry filters applied successfully!");
        }

        function initiateSimulatedCall(driverName) {
            const overlay = document.getElementById('simulated-call-overlay');
            const nameLabel = document.getElementById('call-driver-name');
            const statusLabel = document.getElementById('call-status-label');
            const timerLabel = document.getElementById('call-timer');

            nameLabel.innerText = driverName;
            statusLabel.innerText = "DIALING...";
            timerLabel.classList.add('hidden');
            overlay.classList.remove('hidden');

            callSeconds = 0;
            if (callTimerInterval) clearInterval(callTimerInterval);

            setTimeout(() => {
                statusLabel.innerText = "CONNECTED";
                timerLabel.classList.remove('hidden');
                timerLabel.innerText = "00:00";
                
                callTimerInterval = setInterval(() => {
                    callSeconds++;
                    const minutes = Math.floor(callSeconds / 60).toString().padStart(2, '0');
                    const seconds = (callSeconds % 60).toString().padStart(2, '0');
                    timerLabel.innerText = `${minutes}:${seconds}`;
                }, 1000);
            }, 2500);

            showToastNotification(`<i class="fa-solid fa-phone-volume mr-2 animate-bounce"></i> Calling ${driverName}...`);
        }

        function hangUpSimulatedCall() {
            if (callTimerInterval) {
                clearInterval(callTimerInterval);
                callTimerInterval = null;
            }
            document.getElementById('simulated-call-overlay').classList.add('hidden');
            showToastNotification("<i class='fa-solid fa-phone-slash mr-2 text-rose-500'></i> Call disconnected.");
        }

        let activeChatDriver = "";
        const driverResponses = [
            "Just arrived at the sorting branch. Loading now!",
            "Stuck in moderate traffic near Zapote. It should clear up in 10 minutes.",
            "Perfect. I am heading to your destination coordinate right away.",
            "I'm at the location but looking for a parking spot.",
            "Package was dispatched and signed successfully!"
        ];
        let driverResponseIndex = 0;

        function openDriverChat(driverName) {
            activeChatDriver = driverName;
            const chatWindow = document.getElementById('simulated-chat-window');
            document.getElementById('chat-driver-name').innerText = driverName;
            
            chatWindow.classList.remove('hidden');
            setTimeout(() => {
                chatWindow.classList.remove('opacity-0', 'translate-y-4');
            }, 10);

            const container = document.getElementById('chat-messages-container');
            container.innerHTML = `
                <div class="bg-slate-200/60 p-2.5 rounded-xl max-w-[85%] self-start text-slate-700">
                    <p class="font-bold text-[10px] text-slate-500 mb-0.5">${driverName}</p>
                    <p>Hello! I am currently handling your shipment. Let me know if you have any questions.</p>
                </div>
            `;
            container.scrollTop = container.scrollHeight;
        }

        function closeDriverChat() {
            const chatWindow = document.getElementById('simulated-chat-window');
            chatWindow.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => {
                chatWindow.classList.add('hidden');
            }, 300);
        }

        function handleChatEnterKey(e) {
            if (e.key === "Enter") {
                sendDriverChatMessage();
            }
        }

        function sendDriverChatMessage() {
            const input = document.getElementById('chat-text-input');
            const messageText = input.value.trim();
            if (!messageText) return;

            const container = document.getElementById('chat-messages-container');
            container.innerHTML += `
                <div class="bg-indigo-600 text-white p-2.5 rounded-xl max-w-[85%] self-end text-right shadow-sm">
                    <p class="font-bold text-[10px] text-indigo-200 mb-0.5">Me (Dispatcher)</p>
                    <p>${messageText}</p>
                </div>
            `;
            
            input.value = "";
            container.scrollTop = container.scrollHeight;

            setTimeout(() => {
                const driverReply = driverResponses[driverResponseIndex % driverResponses.length];
                driverResponseIndex++;

                container.innerHTML += `
                    <div class="bg-slate-200/60 p-2.5 rounded-xl max-w-[85%] self-start text-slate-700 animate-fade-in">
                        <p class="font-bold text-[10px] text-slate-500 mb-0.5">${activeChatDriver}</p>
                        <p>${driverReply}</p>
                    </div>
                `;
                container.scrollTop = container.scrollHeight;
                showToastNotification(`<i class="fa-solid fa-message text-indigo-500 mr-2"></i> Message from ${activeChatDriver}`);
            }, 1500);
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab-view').forEach(view => view.classList.add('hidden'));
            document.getElementById('fullscreen-map-wrapper').classList.add('hidden');
            document.getElementById('main-header').classList.remove('hidden');

            const activeView = document.getElementById(`view-${tabId}`);
            if(activeView) activeView.classList.remove('hidden');

            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('bg-[#29355e]', 'text-white');
                link.classList.add('text-slate-400');
            });
            const activeBtn = document.getElementById(`btn-${tabId}`);
            if(activeBtn) activeBtn.classList.add('bg-[#29355e]', 'text-white');

            if(pagesMetaData[tabId]) {
                document.getElementById('page-title').innerText = pagesMetaData[tabId].title;
                document.getElementById('page-desc').innerText = pagesMetaData[tabId].desc;
            }
        }

        function globalSearchEngine() {
            const query = document.getElementById('global-search-input').value.toLowerCase().trim();
            
            const dashboardRows = document.querySelectorAll('#dashboard-shipment-list > div');
            dashboardRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(query)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });

            const trackerCards = document.querySelectorAll('.tracking-card');
            trackerCards.forEach(card => {
                const text = card.innerText.toLowerCase();
                if (text.includes(query)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        function triggerReportDownload() {
            showToastNotification("<i class='fa-solid fa-file-csv mr-2'></i> Preparing spreadsheet log parameters...", "bg-indigo-600");
            setTimeout(() => {
                showToastNotification("<i class='fa-solid fa-circle-check mr-2'></i> Report 'logistics-export-2026.csv' compiled successfully!", "bg-emerald-600");
                
                const csvRows = [
                    ["ShipmentID", "Driver", "Route", "Status", "ETA"],
                    ...serverShipments.map(s => [s.shipment_code, s.driver_name, s.route_path, s.status, s.estimated_arrival])
                ];
                const csvContent = "data:text/csv;charset=utf-8," + csvRows.map(e => e.join(",")).join("\n");
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "logistics-export-2026.csv");
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }, 1000);
        }

        function triggerCustomerNotification() {
            showToastNotification("<i class='fa-solid fa-bell mr-2 animate-bounce'></i> SMS notifications sent to client successfully!", "bg-indigo-600");
        }

        function showToastNotification(message, bgClass = "bg-slate-800") {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `${bgClass} text-white px-4 py-3 rounded-xl text-xs font-semibold shadow-xl border border-white/10 pointer-events-auto transition-all duration-300 transform translate-y-10 opacity-0 flex items-center justify-between min-w-[280px]`;
            toast.innerHTML = `<span>${message}</span><button onclick="this.parentElement.remove()" class="text-white/60 hover:text-white pl-4"><i class="fa-solid fa-xmark"></i></button>`;
            
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            }, 50);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'scale-90');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        function switchScheduleList(categoryKey) {
            document.querySelectorAll('.sched-cat-btn').forEach(btn => {
                btn.className = "sched-cat-btn w-full text-left p-2.5 rounded-xl border border-slate-200 font-bold text-slate-700 text-xs flex justify-between items-center bg-white";
            });

            const targetBtn = document.getElementById(`sched-btn-${categoryKey}`);
            if (targetBtn) {
                targetBtn.className = "sched-cat-btn w-full text-left p-2.5 rounded-xl border border-indigo-300 font-bold text-indigo-700 text-xs flex justify-between items-center bg-indigo-50/50 shadow-sm";
            }

            const targetContainer = document.getElementById('schedule-subtable-box');
            if (scheduleSubTableTemplates[categoryKey]) {
                targetContainer.innerHTML = scheduleSubTableTemplates[categoryKey];
            }
        }

        function triggerScheduleLayoutOverview(id) {
            const record = seeOrderDetailsMap[id];
            if (!record) return;

            switchScheduleList('pendings');

            const targetContainer = document.getElementById('schedule-subtable-box');
            targetContainer.innerHTML = `
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-xs text-slate-700 flex items-center gap-1.5"><i class="fa-solid fa-map-location-dot text-indigo-600"></i> Route Vectors Map Overview</h4>
                    </div>
                    
                    <div class="h-44 bg-[#e2f0d9] rounded-xl relative overflow-hidden border border-slate-200">
                        <div class="absolute inset-0">
                            <svg class="w-full h-full" viewBox="0 0 400 176" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="400" height="176" fill="#e2f0d9" />
                                <circle cx="300" cy="50" r="80" fill="#cbe3c5" opacity="0.5"/>
                                <circle cx="100" cy="140" r="100" fill="#cbe3c5" opacity="0.3"/>
                                <path d="M 50,40 L 150,55 L 220,130 L 350,110" stroke="#1e40af" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M 50,40 L 150,55 L 220,130 L 350,110" stroke="#3b82f6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <g transform="translate(50, 40)">
                                    <circle cx="0" cy="0" r="8" fill="#ef4444" stroke="#ffffff" stroke-width="1.5"/>
                                    <text x="12" y="3" fill="#1e293b" font-size="8" font-weight="800">Origin</text>
                                </g>
                                <g transform="translate(350, 110)">
                                    <circle cx="0" cy="0" r="8" fill="#10b981" stroke="#ffffff" stroke-width="1.5"/>
                                    <text x="-50" y="3" fill="#1e293b" font-size="8" font-weight="800">Laguna</text>
                                </g>
                            </svg>
                        </div>
                        <div class="absolute inset-0 bg-black/10 flex flex-col justify-between p-3 text-white">
                            <span class="bg-indigo-600/90 text-[10px] font-bold px-2 py-0.5 rounded self-start shadow-sm flex items-center gap-1">
                                <i class="fa-solid fa-location-crosshairs"></i> GPS Live Vectors Active
                            </span>
                            <div class="bg-black/40 backdrop-blur-md p-2 rounded-lg text-[10px] font-medium max-w-xs space-y-0.5">
                                <p class="font-bold text-amber-400">Estimated duration: 1 hr 7 min</p>
                                <p class="text-slate-300">Total distance: 24.9 km</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-[10px] bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <div><span class="text-slate-400 block uppercase font-bold text-[8px]">Order ID</span><strong class="text-slate-800">${record.id}</strong></div>
                        <div><span class="text-slate-400 block uppercase font-bold text-[8px]">Customer Name</span><strong class="text-slate-800">${record.customerName}</strong></div>
                        <div><span class="text-slate-400 block uppercase font-bold text-[8px]">Order Status</span><span class="px-1.5 py-0.5 bg-indigo-100 text-indigo-700 rounded font-bold uppercase text-[8px]">En Route</span></div>
                        <div class="col-span-2"><span class="text-slate-400 block uppercase font-bold text-[8px]">Delivery Address</span><strong class="text-slate-700">${record.address}</strong></div>
                        <div><span class="text-slate-400 block uppercase font-bold text-[8px]">Phone #</span><strong class="text-slate-700 font-mono">${record.phone}</strong></div>
                        <div><span class="text-slate-400 block uppercase font-bold text-[8px]">Order Details</span><strong class="text-slate-700">${record.orderDetails}</strong></div>
                        <div><span class="text-slate-400 block uppercase font-bold text-[8px]">Quantity</span><strong class="text-slate-800">${record.qty}</strong></div>
                        <div><span class="text-slate-400 block uppercase font-bold text-[8px]">Payment Status</span><strong class="text-emerald-600">${record.paymentStatus}</strong></div>
                        <div><span class="text-slate-400 block uppercase font-bold text-[8px]">Delivery Cost</span><strong class="text-indigo-600 font-bold">${record.cost}</strong></div>
                    </div>
                </div>
            `;

            showToastNotification(`<i class="fa-solid fa-magnifying-glass-location"></i> Loading route profile details for ${record.customerName}`, "bg-indigo-600");
        }

        function selectTrackingOrder(orderKey) {
            document.querySelectorAll('.tracking-card').forEach(card => {
                card.classList.remove('border-indigo-500', 'bg-indigo-50/40');
                card.classList.add('border-slate-200', 'bg-slate-50/50');
            });

            const selectedCard = document.getElementById(`card-track-${orderKey}`);
            if (selectedCard) {
                selectedCard.classList.remove('border-slate-200', 'bg-slate-50/50');
                selectedCard.classList.add('border-indigo-500', 'bg-indigo-50/40');
            }

            const data = trackingOverlayDataset[orderKey];
            if (!data) return;

            document.getElementById('overlay-driver-name').innerText = data.driver;
            document.getElementById('overlay-carrier-label').innerText = data.carrier;
            document.getElementById('overlay-shipment-id').innerText = data.id;

            const timelineContainer = document.getElementById('overlay-timeline-container');
            timelineContainer.innerHTML = '';

            data.timeline.forEach(step => {
                const dotColor = step.active ? 'bg-orange-400' : 'bg-slate-400';
                const textStyle = step.active ? 'text-slate-800 font-semibold' : 'text-slate-500 font-medium';
                const statusTextStyle = step.active ? 'text-orange-500' : 'text-slate-400';

                timelineContainer.innerHTML += `
                    <div class="relative">
                        <span class="absolute -left-[16.5px] top-0.5 w-2 h-2 rounded-full ${dotColor} ring-4 ring-white"></span>
                        <div class="flex justify-between ${textStyle}">
                            <div>
                                <p>${step.date}</p>
                                <p class="text-[10px] ${statusTextStyle}">${step.status}</p>
                            </div>
                            <span class="text-[10px] text-slate-400">${step.time}</span>
                        </div>
                    </div>
                `;
            });

            document.getElementById('tracking-timeline-overlay').classList.remove('hidden');
        }

        function promptCancellation() {
            document.getElementById('status-cancel-confirm-overlay').classList.remove('hidden');
        }

        function confirmCancellationAction(shouldCancel) {
            document.getElementById('status-cancel-confirm-overlay').classList.add('hidden');
            if (shouldCancel) {
                showToastNotification("<i class='fa-solid fa-circle-check mr-1'></i> Shipment order cancelled successfully.", "bg-rose-600");
            } else {
                showToastNotification("Cancellation dismissed safely.", "bg-slate-700");
            }
        }

        function updateStatusTabDetails() {
            const data = statusOrders[currentStatusIndex];
            if (!data) return;

            document.getElementById('status-order-code').innerText = data.code;
            document.getElementById('status-shipping-date').innerText = data.shippingDate;
            document.getElementById('status-order-id').innerText = data.orderId;
            document.getElementById('status-origin').innerText = data.origin;
            document.getElementById('status-destination').innerText = data.destination;
            document.getElementById('status-duration').innerText = data.duration;
            document.getElementById('status-dep-time').innerText = data.depTime;
            document.getElementById('status-arr-time').innerText = data.arrTime;

            document.getElementById('status-progress-fill').style.width = data.progressWidth;
            document.getElementById('status-map-label').innerText = data.mapLabel;
        }

        function nextStatusOrder() {
            currentStatusIndex = (currentStatusIndex + 1) % statusOrders.length;
            updateStatusTabDetails();
        }

        function prevStatusOrder() {
            currentStatusIndex = (currentStatusIndex - 1 + statusOrders.length) % statusOrders.length;
            updateStatusTabDetails();
        }

        function filterDashboardShipments(category) {
            ['all', 'transit', 'delayed', 'delivered'].forEach(cat => {
                const btn = document.getElementById(`filter-${cat}`);
                if(btn) btn.className = "px-3 py-1 font-medium rounded-md transition-all text-slate-500 hover:text-slate-800";
            });
            const targetBtn = document.getElementById(`filter-${category}`);
            if(targetBtn) targetBtn.className = "px-3 py-1 font-semibold rounded-md transition-all text-indigo-600 bg-white shadow-sm";

            const container = document.getElementById('dashboard-shipment-list');
            if (!container) return;
            container.innerHTML = '';
            
            const records = shipmentFilterData[category] || [];
            records.forEach(item => {
                container.innerHTML += `
                    <div class="p-4 grid grid-cols-3 items-center hover:bg-slate-50 transition cursor-pointer" onclick="switchTab('tracking'); selectTrackingOrder('${item.id.replace(' - ', '-')}');">
                        <div>
                            <div class="flex items-center gap-1.5 text-xs font-bold text-slate-800">
                                <span class="w-2 h-2 rounded-full ${item.dotClass}"></span> ${item.id}
                            </div>
                            <span class="text-[11px] text-slate-400 pl-3.5 block mt-0.5">${item.driver}</span>
                        </div>
                        <div class="text-center">
                            <div class="text-xs font-semibold text-slate-700">${item.route}</div>
                            <span class="text-[10px] text-slate-400 block">${item.time}</span>
                        </div>
                        <div class="text-right">
                            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full ${item.statusClass} inline-block">${item.status}</span>
                            <span class="text-[10px] text-slate-400 block mt-1">${item.meta}</span>
                        </div>
                    </div>
                `;
            });
        }

        function searchTrackers() {
            const query = document.getElementById('tracking-search-input').value.toLowerCase();
            const cards = document.querySelectorAll('.tracking-card');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(query)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        function searchSchedulesDrivers() {
            const query = document.getElementById('schedule-search-input').value.toLowerCase();
            const rows = document.querySelectorAll('.schedule-driver-row');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(query)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        function openFullscreenMap() {
            document.querySelectorAll('.tab-view').forEach(view => view.classList.add('hidden'));
            document.getElementById('main-header').classList.add('hidden');
            document.getElementById('fullscreen-map-wrapper').classList.remove('hidden');
        }

        function closeFullscreenMap() {
            document.getElementById('fullscreen-map-wrapper').classList.add('hidden');
            document.getElementById('main-header').classList.remove('hidden');
            switchTab('dashboard');
        }

        const pagesMetaData = {
            dashboard: { title: "Dashboard", desc: "Monitor your shipments and logistics in real-time" },
            tracking: { title: "Shipment Tracking", desc: "Live shipment tracking with timeline events, location updates, and delivery status" },
            schedules: { title: "Delivery Schedules", desc: "Lists of Paid, Pendings, COD, In-transit, Cancelled, On-hold, and Delivered" },
            status: { title: "Shipment Status", desc: "Live shipment tracking and delivery state loops" }
        };

        document.addEventListener("DOMContentLoaded", () => {
            switchTab('dashboard'); 
            const firstShipment = serverShipments[0];
            if (firstShipment) {
                const initialKey = firstShipment.shipment_code.replace(' - ', '-');
                selectTrackingOrder(initialKey);
            }
            updateStatusTabDetails();
            switchScheduleList('paid');
            filterDashboardShipments('all');
        });
    </script>
</body>
</html>