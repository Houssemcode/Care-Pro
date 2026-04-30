<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'My Bookings')
    <x-family.head />
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col w-full overflow-x-hidden">

    <x-family.navbar :active="'requests'" />

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col page-enter">
        
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between md:items-end mb-8 sm:mb-10 gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-display font-extrabold text-slate-900 mb-1 sm:mb-2">My Bookings</h1>
                <p class="text-sm sm:text-base text-slate-500 font-medium">Track your caregiving requests and manage active contracts.</p>
            </div>
            <a href="{{ route('family.browse') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-brand-500/30 active:scale-95 w-fit">
                Find a Caregiver
            </a>
        </div>

        {{-- Notifications --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Bookings List --}}
        <div class="space-y-4 sm:space-y-6">
            @forelse($requests as $req)
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-5 sm:p-6 flex flex-col md:flex-row gap-6 md:items-center justify-between transition-colors hover:border-brand-200 relative overflow-hidden group">
                    
                    {{-- Caregiver Info --}}
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xl shadow-md shrink-0">
                            {{ strtoupper(substr($req->offre->employee->user->name ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-display font-bold text-lg text-slate-900">{{ $req->offre->employee->user->name ?? 'Caregiver' }}</h3>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">#REQ-{{ $req->id }}</span>
                            </div>
                            <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-md ring-1 ring-inset ring-brand-500/20">
                                {{ $req->offre->service_type ?? 'Service' }}
                            </span>
                        </div>
                    </div>

                    {{-- Dates --}}
                    <div class="flex flex-col text-sm font-medium text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider w-8">From</span>
                            <span class="text-slate-800">{{ \Carbon\Carbon::parse($req->start_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider w-8">To</span>
                            <span class="text-slate-800">{{ \Carbon\Carbon::parse($req->end_date)->format('M d, Y') }}</span>
                        </div>
                    </div>

                    {{-- Status & Actions --}}
                    <div class="flex flex-col items-start md:items-end gap-3 shrink-0">
                        @if($req->status === 'pending')
                            <span class="inline-flex px-3 py-1.5 text-xs font-bold text-amber-700 bg-amber-50 rounded-lg ring-1 ring-inset ring-amber-500/20 uppercase tracking-wider">
                                Awaiting Approval
                            </span>
                            
                        @elseif($req->status === 'assigned')
                            <span class="inline-flex px-3 py-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 rounded-lg ring-1 ring-inset ring-emerald-500/20 uppercase tracking-wider">
                                Contract Active
                            </span>
                            
                            <div class="flex items-center gap-4 mt-1">
                                <!-- The old Report Button -->
                                <button onclick="openReportModal('{{ $req->offre->employee->id }}', '{{ addslashes($req->offre->employee->user->name) }}')" class="text-xs font-bold text-rose-500 hover:text-rose-700 underline underline-offset-2 transition-colors">
                                    Report an Issue
                                </button>

                                <span class="text-slate-300">|</span>

                                <!-- NEW: The Leave a Review Button -->
                                <button onclick="openReviewModal('{{ \App\Models\AssignmentService::where('offre_id', $req->offre_id)->where('family_id', Auth::user()->family->id)->value('id') }}', '{{ addslashes($req->offre->employee->user->name) }}')" class="text-xs font-bold text-amber-500 hover:text-amber-700 underline underline-offset-2 transition-colors">
                                    Leave a Review
                                </button>
                            </div>

                        @else
                            <span class="inline-flex px-3 py-1.5 text-xs font-bold text-rose-700 bg-rose-50 rounded-lg ring-1 ring-inset ring-rose-500/20 uppercase tracking-wider">
                                Request Declined
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-16 text-center bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">No Bookings Found</h3>
                    <p class="text-slate-500 font-medium text-sm mb-6">You haven't requested any caregivers yet.</p>
                    <a href="{{ route('family.browse') }}" class="inline-flex px-5 py-2.5 bg-brand-50 text-brand-700 font-bold rounded-xl text-sm transition-all hover:bg-brand-100">
                        Browse Caregivers
                    </a>
                </div>
            @endforelse
            
            {{-- Pagination --}}
            @if(method_exists($requests, 'hasPages') && $requests->hasPages())
                <div class="mt-6">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </main>

    {{-- Report Modal --}}
    <div id="modal-report" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeReportModal()">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-report-content">
            
            <form id="report-form" method="POST" action="{{ route('family.reports.store') }}">
                @csrf
                <input type="hidden" name="employee_id" id="report_employee_id" value="">
                
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Report Caregiver</h3>
                    <button type="button" onclick="closeReportModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="bg-rose-50 border border-rose-100 rounded-xl p-4 text-rose-800 mb-2">
                        <p class="text-sm font-medium">You are filing a dispute against <strong id="report_caregiver_name" class="font-bold">...</strong>. Admin will review this case.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Reason for Report <span class="text-rose-500">*</span></label>
                        <select name="report_reason" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-medium appearance-none bg-white">
                            <option value="" disabled selected>Select a reason...</option>
                            <option value="No Show / Lateness">No Show / Excessive Lateness</option>
                            <option value="Unprofessional Behavior">Unprofessional Behavior</option>
                            <option value="Poor Service Quality">Poor Service Quality</option>
                            <option value="Safety Concern">Safety Concern</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Additional Details <span class="text-rose-500">*</span></label>
                        <textarea name="description" required rows="3" placeholder="Please provide specific details about the incident..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-medium resize-none"></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeReportModal()" class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm active:scale-95">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-rose-500/30 active:scale-95">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
    {{-- Review Modal --}}
    <div id="modal-review" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeReviewModal()">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-review-content">
            
            <form method="POST" action="{{ route('family.ratings.store') }}">
                @csrf
                <input type="hidden" name="assignment_service_id" id="review_assignment_id" value="">
                
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Rate Caregiver</h3>
                    <button type="button" onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="text-center">
                        <p class="text-sm font-medium text-slate-500 mb-4">How was your experience with <strong id="review_caregiver_name" class="text-slate-800">...</strong>?</p>
                        
                        {{-- Interactive CSS Stars --}}
                        <div class="flex flex-row-reverse justify-center gap-2">
                            <input type="radio" id="star5" name="stars" value="5" class="peer sr-only" required />
                            <label for="star5" class="cursor-pointer text-slate-300 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>

                            <input type="radio" id="star4" name="stars" value="4" class="peer sr-only" />
                            <label for="star4" class="cursor-pointer text-slate-300 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>

                            <input type="radio" id="star3" name="stars" value="3" class="peer sr-only" />
                            <label for="star3" class="cursor-pointer text-slate-300 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>

                            <input type="radio" id="star2" name="stars" value="2" class="peer sr-only" />
                            <label for="star2" class="cursor-pointer text-slate-300 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>

                            <input type="radio" id="star1" name="stars" value="1" class="peer sr-only" />
                            <label for="star1" class="cursor-pointer text-slate-300 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Write a Review (Optional)</label>
                        <textarea name="comment" rows="3" placeholder="Tell us what you liked about this caregiver..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-amber-500 outline-none text-sm font-medium resize-none"></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeReviewModal()" class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm active:scale-95">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-amber-500/30 active:scale-95">Submit Review</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Report Modal Logic
        const reportModal = document.getElementById('modal-report');
        const reportModalContent = document.getElementById('modal-report-content');

        function openReportModal(employeeId, caregiverName) {
            document.getElementById('report_employee_id').value = employeeId;
            document.getElementById('report_caregiver_name').textContent = caregiverName;
            
            reportModal.classList.remove('invisible', 'opacity-0');
            setTimeout(() => reportModalContent.classList.remove('scale-95', 'opacity-0'), 50);
        }

        function closeReportModal() {
            reportModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => reportModal.classList.add('invisible', 'opacity-0'), 200);
        }

        const reviewModal = document.getElementById('modal-review');
        const reviewModalContent = document.getElementById('modal-review-content');

        function openReviewModal(assignmentId, caregiverName) {
            document.getElementById('review_assignment_id').value = assignmentId;
            document.getElementById('review_caregiver_name').textContent = caregiverName;
            
            reviewModal.classList.remove('invisible', 'opacity-0');
            setTimeout(() => reviewModalContent.classList.remove('scale-95', 'opacity-0'), 50);
        }

        function closeReviewModal() {
            reviewModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => reviewModal.classList.add('invisible', 'opacity-0'), 200);
        }
    </script>
</body>

</html>