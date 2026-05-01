<x-layouts.family active="requests">
    @section('title', 'My Bookings')

    <x-family.page-header 
        breadcrumb="Bookings" 
        title="My Bookings" 
        subtitle="Track your caregiving requests and manage active contracts."
    >
        <x-slot name="actions">
            <a href="{{ route('family.browse') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-brand-500/30 active:scale-95">
                Find a Caregiver
            </a>
        </x-slot>
    </x-family.page-header>

    {{-- Notifications --}}
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Bookings List --}}
    <div class="space-y-4 sm:space-y-6">
        @forelse($requests as $req)
            <div class="bg-white rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 p-6 flex flex-col md:flex-row gap-6 md:items-center justify-between transition-all hover:border-brand-200 group relative">
                
                {{-- Caregiver Info --}}
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-2xl shadow-md shrink-0">
                        {{ strtoupper(substr($req->offre->employee->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-display font-bold text-lg text-slate-900 group-hover:text-brand-600 transition-colors">{{ $req->offre->employee->user->name ?? 'Caregiver' }}</h3>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-0.5 rounded-full border border-slate-100">#REQ-{{ $req->id }}</span>
                        </div>
                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold text-brand-700 bg-brand-50 rounded-lg ring-1 ring-inset ring-brand-500/20">
                            {{ $req->offre->service_type ?? 'Service' }}
                        </span>
                    </div>
                </div>

                {{-- Dates --}}
                <div class="flex flex-col text-sm font-medium text-slate-600 bg-slate-50/50 p-3 sm:p-4 rounded-[1.25rem] border border-slate-100 w-full md:w-auto md:min-w-[200px]">
                    <div class="flex items-center gap-3 mb-1.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider w-8">From</span>
                        <span class="text-slate-800 font-bold">{{ \Carbon\Carbon::parse($req->start_date)->format('M d, Y') }}</span>
                    </div >
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider w-8">To</span>
                        <span class="text-slate-800 font-bold">{{ \Carbon\Carbon::parse($req->end_date)->format('M d, Y') }}</span>
                    </div >
                </div >

                {{-- Status & Actions --}}
                <div class="flex flex-col items-start md:items-end gap-3 shrink-0">
                    @if($req->status === 'pending')
                        <span class="inline-flex px-3 py-1.5 text-[10px] font-bold text-amber-700 bg-amber-50 rounded-lg ring-1 ring-inset ring-amber-500/20 uppercase tracking-widest">
                            Awaiting Approval
                        </span>
                        <div class="flex flex-wrap gap-3 mt-1">
                            <button onclick="openDiscussionModal({{ $req->id }}, {{ $req->messages->toJson() }})" class="text-[10px] font-bold text-slate-500 hover:text-brand-600 flex items-center gap-1.5 transition-colors uppercase tracking-widest whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                Price Discussion
                            </button>
                            <button onclick="openEditRequestModal({{ $req->id }}, '{{ $req->start_date }}', '{{ $req->end_date }}')" class="text-[10px] font-bold text-slate-500 hover:text-brand-600 flex items-center gap-1.5 transition-colors uppercase tracking-widest whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Request
                            </button>
                        </div>
                        
                    @elseif($req->status === 'assigned')
                        <span class="inline-flex px-3 py-1.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-lg ring-1 ring-inset ring-emerald-500/20 uppercase tracking-widest">
                            Contract Active
                        </span>
                        <div class="flex flex-col items-start md:items-end gap-2 mt-1">
                            <button onclick="openDiscussionModal({{ $req->id }}, {{ $req->messages->toJson() }})" class="text-[10px] font-bold text-slate-500 hover:text-brand-600 flex items-center gap-1.5 transition-colors uppercase tracking-widest">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                Price Discussion
                            </button>
                            
                            <div class="flex items-center gap-3">
                                <button onclick="openReportModal('{{ $req->offre->employee->id }}', '{{ addslashes($req->offre->employee->user->name) }}')" class="text-[10px] font-bold text-rose-500 hover:text-rose-700 uppercase tracking-widest transition-colors">
                                    Report Issue
                                </button>
                                <span class="text-slate-200">|</span>
                                <button onclick="openReviewModal('{{ \App\Models\AssignmentService::where('offre_id', $req->offre_id)->where('family_id', Auth::user()->family->id)->value('id') }}', '{{ addslashes($req->offre->employee->user->name) }}')" class="text-[10px] font-bold text-amber-500 hover:text-amber-600 uppercase tracking-widest transition-colors">
                                    Leave Review
                                </button>
                            </div>
                        </div>

                    @else
                        <span class="inline-flex px-3 py-1.5 text-[10px] font-bold text-rose-700 bg-rose-50 rounded-lg ring-1 ring-inset ring-rose-500/20 uppercase tracking-widest">
                            Request Declined
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-20 text-center bg-white rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-display font-bold text-slate-800 mb-2">No Bookings Found</h3>
                <p class="text-slate-500 font-medium text-sm mb-8">You haven't requested any caregivers yet.</p>
                <a href="{{ route('family.browse') }}" class="inline-flex px-8 py-3 bg-brand-600 text-white font-bold rounded-xl text-sm transition-all hover:bg-brand-700 shadow-lg shadow-brand-500/20">
                    Browse Caregivers
                </a>
            </div>
        @endforelse
        
        {{-- Pagination --}}
        @if(method_exists($requests, 'hasPages') && $requests->hasPages())
            <div class="mt-8">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

    {{-- Report Modal --}}
    <div id="modal-report" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeReportModal()">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-report-content">
            <form id="report-form" method="POST" action="{{ route('family.reports.store') }}">
                @csrf
                <input type="hidden" name="employee_id" id="report_employee_id" value="">
                
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Report Caregiver</h3>
                    <button type="button" onclick="closeReportModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 text-rose-800">
                        <p class="text-sm font-medium">Reporting <strong id="report_caregiver_name" class="font-bold text-rose-900">...</strong>. Our team will review this case shortly.</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Reason for Report <span class="text-rose-500">*</span></label>
                        <select name="report_reason" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium appearance-none cursor-pointer text-slate-700 bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394A3B8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat pr-10">
                            <option value="" disabled selected>Select a reason...</option>
                            <option value="No Show / Lateness">No Show / Excessive Lateness</option>
                            <option value="Unprofessional Behavior">Unprofessional Behavior</option>
                            <option value="Poor Service Quality">Poor Service Quality</option>
                            <option value="Safety Concern">Safety Concern</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Additional Details <span class="text-rose-500">*</span></label>
                        <textarea name="description" required rows="4" placeholder="Please provide specific details about the incident..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium resize-none transition-all"></textarea>
                    </div>
                </div>

                <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeReportModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-rose-500/30 active:scale-95">Submit Report</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Review Modal --}}
    <div id="modal-review" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeReviewModal()">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-review-content">
            <form method="POST" action="{{ route('family.ratings.store') }}">
                @csrf
                <input type="hidden" name="assignment_service_id" id="review_assignment_id" value="">
                
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Rate Caregiver</h3>
                    <button type="button" onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-8 space-y-8">
                    <div class="text-center">
                        <p class="text-sm font-medium text-slate-500 mb-6">How was your experience with <strong id="review_caregiver_name" class="text-slate-900">...</strong>?</p>
                        
                        <div class="flex flex-row-reverse justify-center gap-3">
                            <input type="radio" id="star5" name="stars" value="5" class="peer sr-only" required />
                            <label for="star5" class="cursor-pointer text-slate-200 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>

                            <input type="radio" id="star4" name="stars" value="4" class="peer sr-only" />
                            <label for="star4" class="cursor-pointer text-slate-200 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>

                            <input type="radio" id="star3" name="stars" value="3" class="peer sr-only" />
                            <label for="star3" class="cursor-pointer text-slate-200 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>

                            <input type="radio" id="star2" name="stars" value="2" class="peer sr-only" />
                            <label for="star2" class="cursor-pointer text-slate-200 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>

                            <input type="radio" id="star1" name="stars" value="1" class="peer sr-only" />
                            <label for="star1" class="cursor-pointer text-slate-200 peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400 transition-colors">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Write a Review (Optional)</label>
                        <textarea name="comment" rows="4" placeholder="Tell us what you liked about this caregiver..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-amber-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium resize-none transition-all"></textarea>
                    </div>
                </div>

                <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeReviewModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-amber-500/30 active:scale-95">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Edit Request Modal --}}
    <div id="modal-edit-request" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeEditRequestModal()">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-edit-request-content">
            <form id="edit-request-form" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="font-display font-bold text-lg text-slate-800">Edit Booking Request</h3>
                    <button type="button" onclick="closeEditRequestModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Start Date <span class="text-brand-500">*</span></label>
                            <input type="date" name="start_date" id="edit_start_date" required min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">End Date <span class="text-brand-500">*</span></label>
                            <input type="date" name="end_date" id="edit_end_date" required min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest text-center">Update your required timeframe.</p>
                </div>

                <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeEditRequestModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all shadow-sm">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-brand-500/30 active:scale-95">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Discussion Modal --}}
    <div id="modal-discussion" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 invisible transition-all duration-300 flex items-center justify-center p-4" onclick="if(event.target===this) closeDiscussionModal()">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden h-[600px]" id="modal-discussion-content">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 class="font-display font-bold text-lg text-slate-800">Price Discussion</h3>
                <button type="button" onclick="closeDiscussionModal()" class="text-slate-400 hover:text-slate-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/30 custom-scrollbar" id="message-container"></div>

            <form id="message-form" method="POST" action="" class="p-5 border-t border-slate-100 bg-white">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="message" required placeholder="Type your message..." class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 bg-slate-50 focus:bg-white outline-none text-sm font-medium transition-all">
                    <button type="submit" class="px-5 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-md active:scale-95">Send</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
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

        const editRequestModal = document.getElementById('modal-edit-request');
        const editRequestModalContent = document.getElementById('modal-edit-request-content');
        const editRequestForm = document.getElementById('edit-request-form');

        function openEditRequestModal(requestId, startDate, endDate) {
            editRequestForm.action = `/family/requests/${requestId}`;
            document.getElementById('edit_start_date').value = startDate.split(' ')[0];
            document.getElementById('edit_end_date').value = endDate.split(' ')[0];
            editRequestModal.classList.remove('invisible', 'opacity-0');
            setTimeout(() => editRequestModalContent.classList.remove('scale-95', 'opacity-0'), 50);
        }

        function closeEditRequestModal() {
            editRequestModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => editRequestModal.classList.add('invisible', 'opacity-0'), 200);
        }

        const discussionModal = document.getElementById('modal-discussion');
        const discussionModalContent = document.getElementById('modal-discussion-content');
        const messageContainer = document.getElementById('message-container');
        const messageForm = document.getElementById('message-form');

        function openDiscussionModal(requestId, messages) {
            messageForm.action = `/family/requests/${requestId}/messages`;
            messageContainer.innerHTML = '';

            if (messages.length === 0) {
                messageContainer.innerHTML = '<div class="text-center py-10 text-slate-400 text-sm">No messages yet. Start the discussion!</div>';
            } else {
                messages.forEach(msg => {
                    const isMe = msg.user_id === {{ Auth::id() }};
                    const div = document.createElement('div');
                    div.className = `flex ${isMe ? 'justify-end' : 'justify-start'}`;
                    div.innerHTML = `
                        <div class="max-w-[85%] rounded-2xl px-4 py-3 text-sm ${isMe ? 'bg-brand-600 text-white rounded-tr-none' : 'bg-white border border-slate-200 text-slate-700 rounded-tl-none shadow-sm'}">
                            <p class="font-medium leading-relaxed">${msg.message}</p>
                            <span class="text-[10px] mt-1 block opacity-70 text-right font-bold uppercase tracking-wider">${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                        </div>
                    `;
                    messageContainer.appendChild(div);
                });
            }

            discussionModal.classList.remove('invisible', 'opacity-0');
            setTimeout(() => {
                discussionModalContent.classList.remove('scale-95', 'opacity-0');
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }, 50);
        }

        function closeDiscussionModal() {
            discussionModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => discussionModal.classList.add('invisible', 'opacity-0'), 200);
        }
    </script>
    @endpush
</x-layouts.family>