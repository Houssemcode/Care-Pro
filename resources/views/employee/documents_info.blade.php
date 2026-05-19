<x-layouts.employee active="profile">
    @section('title', __('Required Documents Information'))

    <x-employee.page-header 
        breadcrumb="{{ __('Account / Required Documents') }}" 
        title="{{ __('Verification Documents Info') }}" 
        subtitle="{{ __('Learn more about the essential documents required to verify your caregiver account.') }}" 
    />

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
        <div class="mb-6">
            <h3 class="font-display font-bold text-lg text-slate-800 mb-2">{{ __('Why we need these documents') }}</h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                {{ __('To ensure the safety and trust of the families using our platform, we require all caregivers to undergo a verification process. Please upload the following documents so our administrators can review and approve your account based on our evaluation system.') }}
            </p>
        </div>

        <div class="mb-8 p-4 bg-brand-50 rounded-xl border border-brand-100">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 text-brand-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-brand-800 text-sm mb-1">{{ __('Evaluation System') }}</h4>
                    <p class="text-xs text-brand-700 leading-relaxed">
                        {!! __('Profiles are evaluated out of :max_points points. To activate your account, you must provide all :mandatory documents and score at least :min_points points across your qualifications and experience.', ['max_points' => '<strong>15</strong>', 'mandatory' => '<strong>'.__('Mandatory').'</strong>', 'min_points' => '<strong>12</strong>']) !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($documentTypes as $type)
                @php
                    $maxPoints = 0;
                    $isMandatory = false;
                    
                    if($type === 'id_card') { $maxPoints = 1; $isMandatory = true; }
                    elseif($type === 'criminal_record') { $maxPoints = 2; $isMandatory = true; }
                    elseif($type === 'medical_certificate') { $maxPoints = 2; }
                    elseif($type === 'certificate') { $maxPoints = 5; }
                    elseif($type === 'resume') { $maxPoints = 5; }
                @endphp

                <div class="p-5 bg-slate-50 border border-slate-100 rounded-xl flex items-start gap-4 transition-all hover:border-slate-200">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                            <h4 class="text-sm font-bold text-slate-800 capitalize">{{ __($type) }}</h4>
                            <div class="flex items-center gap-2">
                                @if($isMandatory)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 tracking-wide uppercase">
                                        {{ __('Mandatory') }}
                                    </span>
                                @endif
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700 tracking-wide uppercase">
                                    {{ __('Up to :points pts', ['points' => $maxPoints]) }}
                                </span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 md:pr-12 rtl:md:pl-12 rtl:md:pr-0">
                            @if($type === 'id_card')
                                {{ __('A valid national identity card or passport to verify your identity.') }}
                            @elseif($type === 'certificate')
                                {{ __('Your professional certificate or diploma proving your qualifications in caregiving.') }}
                            @elseif($type === 'criminal_record')
                                {{ __('A recent police clearance or background check certificate to ensure safety.') }}
                            @elseif($type === 'medical_certificate')
                                {{ __('A health or medical certificate confirming you are fit to work in caregiving.') }}
                            @elseif($type === 'resume')
                                {{ __('Your CV or resume detailing your past experience and skills.') }}
                            @else
                                {{ __('Essential document for account verification.') }}
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('employee.profile') }}" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-xl text-sm hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10">
                {{ __('Back to Profile') }}
            </a>
        </div>
    </div>
</x-layouts.employee>
