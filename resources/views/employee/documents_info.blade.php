<x-layouts.employee active="profile">
    @section('title', 'Required Documents Information')

    <x-employee.page-header 
        breadcrumb="Account / Required Documents" 
        title="Verification Documents Info" 
        subtitle="Learn more about the essential documents required to verify your caregiver account." 
    />

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
        <div class="mb-6">
            <h3 class="font-display font-bold text-lg text-slate-800 mb-2">Why we need these documents</h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                To ensure the safety and trust of the families using our platform, we require all caregivers to undergo a verification process. 
                Please upload the following documents so our administrators can review and approve your account.
            </p>
        </div>

        <div class="space-y-4">
            @foreach($documentTypes as $type)
                <div class="p-5 bg-slate-50 border border-slate-100 rounded-xl flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800 capitalize mb-1">{{ str_replace('_', ' ', $type) }}</h4>
                        <p class="text-xs text-slate-500">
                            @if($type === 'id_card')
                                A valid national identity card or passport to verify your identity.
                            @elseif($type === 'certificate')
                                Your professional certificate or diploma proving your qualifications in caregiving.
                            @elseif($type === 'criminal_record')
                                A recent police clearance or background check certificate to ensure safety.
                            @elseif($type === 'medical_certificate')
                                A health or medical certificate confirming you are fit to work in caregiving.
                            @elseif($type === 'resume')
                                Your CV or resume detailing your past experience and skills.
                            @else
                                Essential document for account verification.
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('employee.profile') }}" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-xl text-sm hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10">
                Back to Profile
            </a>
        </div>
    </div>
</x-layouts.employee>
