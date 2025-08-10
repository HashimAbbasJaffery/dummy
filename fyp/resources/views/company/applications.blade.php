<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Applications - {{ $job->title }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #bfdbfe, #e0e7ff);
            margin: 0;
            padding: 3rem 1rem;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            justify-content: center;
        }

        .container {
            max-width: 960px;
            width: 100%;
            background: #ffffff;
            border-radius: 1.5rem;
            padding: 2.5rem 3rem;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e7ff;
        }

        h1 {
            font-size: 2rem;
            color: #1e40af;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
        }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            justify-content: center;
        }

        .tab {
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            border-radius: 999px;
            cursor: pointer;
            background: #e0e7ff;
            color: #1e3a8a;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .tab.active {
            background: #3b82f6;
            color: #fff;
            border-color: #2563eb;
        }

        .app-card {
            background: #f0f9ff;
            border: 1px solid #dbeafe;
            padding: 1.5rem;
            border-radius: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 6px 16px rgba(191, 219, 254, 0.2);
            position: relative;
        }

        .app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .app-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .app-date {
            font-size: 0.875rem;
            color: #64748b;
        }

        .app-body {
            margin-top: 1rem;
        }

        .app-body p {
            margin: 0.25rem 0;
            font-size: 0.95rem;
        }

        .btn {
            display: inline-block;
            margin-top: 0.75rem;
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
            cursor: pointer;
            border: none;
        }

        .btn:hover {
            background-color: #2563eb;
        }

        .cover-letter {
            margin-top: 1rem;
            background: #fff;
            border: 1px dashed #cbd5e1;
            padding: 1rem;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            color: #334155;
        }

        .no-apps {
            text-align: center;
            font-size: 1rem;
            color: #475569;
        }

        [data-tab-content] {
            display: none;
        }

        [data-tab-content].active {
            display: block;
        }

        /* Actions dropdown */
        .actions-dropdown {
            position: relative;
            display: inline-block;
        }

        .actions-button {
            background-color: #3b82f6;
            border: none;
            color: white;
            padding: 0.4rem 0.75rem;
            font-size: 0.9rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 600;
            user-select: none;
        }

        .actions-button:hover {
            background-color: #2563eb;
        }

        .actions-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            min-width: 220px;
            z-index: 100;
        }

        .actions-menu.show {
            display: block;
        }

        .actions-menu a, .actions-menu button {
            display: block;
            padding: 0.5rem 1rem;
            text-align: left;
            font-size: 0.9rem;
            color: #1e293b;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        .actions-menu a:hover, .actions-menu button:hover {
            background-color: #e0e7ff;
            color: #1e40af;
        }

        /* Interview Invitation Sent Badge */
        .invitation-badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            margin: 0.25rem 0 0 0;
            background-color: #34d399; /* green-400 */
            color: white;
            font-weight: 600;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            user-select: none;
        }

        /* Hired Badge */
        .hired-badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            margin: 0.25rem 0 0 0;
            background-color: #f59e0b; /* amber-500 */
            color: white;
            font-weight: 600;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            user-select: none;
        }

        .badge-row {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }

        @media (max-width: 640px) {
            .app-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
        }
    </style>
</head>
<body>

<div class="container" id="app">
    <h1>📄 Applications for: {{ $job->title }}</h1>

    <div class="tabs">
        <div class="tab active" data-tab="shortlisted">✅ Shortlisted</div>
        <div class="tab" data-tab="not-recommended">🚫 Not Recommended</div>
    </div>

    <div data-tab-content="shortlisted" class="active">
        @php
            $shortlisted = $applications->filter(fn($app) => $app->classification_score >= $job->threshold);
        @endphp

        @forelse($shortlisted as $application)
            @php $medals = ['🏅', '🥈', '🥉']; @endphp
            <div class="app-card" data-application-card="{{ $application->id }}">
                <div class="app-header">
                    <div class="app-name">
                        {{ ($loop->index < 3) ? $medals[$loop->index] . ' ' : '' }}{{ $application->name }}
                        <span class="badge-row">
                            @if($application->questionnaire && $application->interview_invitation)
                                <span class="invitation-badge" role="status" aria-label="Interview Invitation Sent">
                                    📧 Interview Invitation Sent
                                </span>
                            @endif

                            @if($application->is_hired)
                                <span class="hired-badge" role="status" aria-label="Candidate Hired">
                                    🎉 Hired
                                </span>
                            @endif
                        </span>
                    </div>
                    <div class="app-date">Applied on {{ $application->created_at->format('M d, Y') }}</div>
                </div>

                <div class="app-body">
                    <p><strong>Email:</strong> {{ $application->email }}</p>

                    <div class="actions-dropdown">
                        <button class="actions-button" aria-haspopup="true" aria-expanded="false">
                            Actions ▾
                        </button>
                        <div class="actions-menu" role="menu">
                            <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" role="menuitem">Download Resume</a>
                            <a href="{{ asset('storage/' . $application->education_file) }}" target="_blank" role="menuitem">Download Education Certificate</a>

                            <!-- Hire candidate button (AJAX first, fallback to link) -->
                            @if(!$application->is_hired)
                                <button
                                    type="button"
                                    class="hire-btn"
                                    data-hire-url="{{ route('company.candidate.hire', [ 'application' => $application->id ]) }}"
                                    data-application-id="{{ $application->id }}"
                                    role="menuitem"
                                >
                                    Hire candidate
                                </button>
                            @endif

                            @if($application->questionnaire)
                                <a href="{{ route('company.job.questionnaire', ['application' => $application->id]) }}" role="menuitem">View Questionnaire</a>
                                @unless($application->interview_invitation)
                                    <button type="button" class="send-invite-btn" data-application-id="{{ $application->id }}" role="menuitem">
                                        Send Interview Invitation
                                    </button>
                                @endunless
                            @endif
                        </div>
                    </div>

                    @if($application->cover_letter)
                        <div class="cover-letter">
                            <strong>Cover Letter:</strong><br>
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="no-apps">No shortlisted applications.</p>
        @endforelse
    </div>

    <div data-tab-content="not-recommended">
        @php
            $rejected = $applications->filter(fn($app) => $app->classification_score < $job->threshold);
        @endphp

        @forelse($rejected as $application)
            <div class="app-card" data-application-card="{{ $application->id }}">
                <div class="app-header">
                    <div class="app-name">{{ $application->name }}</div>
                    <div class="app-date">Applied on {{ $application->created_at->format('M d, Y') }}</div>
                </div>

                <div class="app-body">
                    <p><strong>Email:</strong> {{ $application->email }}</p>

                    <div class="actions-dropdown">
                        <button class="actions-button" aria-haspopup="true" aria-expanded="false">
                            Actions ▾
                        </button>
                        <div class="actions-menu" role="menu">
                            <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" role="menuitem">Downlad Resume</a>
                            <a href="{{ asset('storage/' . $application->education_file) }}" target="_blank" role="menuitem">Download Education Certificate</a>
                            @if($application->questionnaire)
                                <a href="{{ route('company.job.questionnaire', ['application' => $application->id]) }}" role="menuitem">View Questionnaire</a>
                            @endif
                        </div>
                    </div>

                    @if($application->cover_letter)
                        <div class="cover-letter">
                            <strong>Cover Letter:</strong><br>
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="no-apps">No non-recommended applications.</p>
        @endforelse
    </div>
</div>

<script>
    // Tabs switching
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('[data-tab-content]');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            tab.classList.add('active');
            const target = tab.getAttribute('data-tab');
            document.querySelector(`[data-tab-content="${target}"]`).classList.add('active');
        });
    });

    // Actions dropdown toggle
    document.querySelectorAll('.actions-button').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            closeAllDropdowns();

            const menu = button.nextElementSibling;
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', !expanded);
            if (!expanded) {
                menu.classList.add('show');
            } else {
                menu.classList.remove('show');
            }
        });
    });

    // Close all dropdowns on clicking outside
    function closeAllDropdowns() {
        document.querySelectorAll('.actions-menu.show').forEach(menu => {
            menu.classList.remove('show');
            const btn = menu.previousElementSibling;
            if (btn) btn.setAttribute('aria-expanded', 'false');
        });
    }
    document.addEventListener('click', closeAllDropdowns);

    // Send Interview Invitation button handler inside dropdown
    document.querySelectorAll('.send-invite-btn').forEach(button => {
        button.addEventListener('click', () => {
            const applicationId = button.dataset.applicationId;

            Swal.fire({
                title: 'Send Interview Invitation',
                html:
                    `<input type="date" id="interview_date" class="swal2-input" placeholder="Interview Date" required>` +
                    `<input type="time" id="interview_time" class="swal2-input" placeholder="Interview Time" required>` +
                    `<input type="text" id="location" class="swal2-input" placeholder="Location" required>`,
                focusConfirm: false,
                showCancelButton: true,
                preConfirm: () => {
                    const date = Swal.getPopup().querySelector('#interview_date').value;
                    const time = Swal.getPopup().querySelector('#interview_time').value;
                    const location = Swal.getPopup().querySelector('#location').value;

                    if (!date || !time || !location) {
                        Swal.showValidationMessage(`Please enter date, time, and location`);
                    }
                    return { date, time, location };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = {
                        interview_date: result.value.date,
                        interview_time: result.value.time,
                        location: result.value.location,
                        _token: '{{ csrf_token() }}'
                    };

                    axios.post(`/company/application/${applicationId}/interview`, data)
                        .then(() => {
                            Swal.fire('Success!', 'Interview invitation sent.', 'success').then(() => {
                                // Update UI: add "Interview Invitation Sent" badge if not shown
                                const card = document.querySelector(`[data-application-card="${applicationId}"]`);
                                if (card && !card.querySelector('.invitation-badge')) {
                                    const badgeRow = card.querySelector('.badge-row') || card.querySelector('.app-name');
                                    const span = document.createElement('span');
                                    span.className = 'invitation-badge';
                                    span.setAttribute('role', 'status');
                                    span.setAttribute('aria-label', 'Interview Invitation Sent');
                                    span.textContent = '📧 Interview Invitation Sent';
                                    badgeRow.appendChild(span);
                                }
                                closeAllDropdowns();
                            });
                        })
                        .catch(() => {
                            Swal.fire('Error!', 'Failed to send invitation.', 'error');
                        });
                }
            });
        });
    });

    // Hire candidate (AJAX first; fallback to opening link)
    document.querySelectorAll('.hire-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.stopPropagation();
            const url = button.dataset.hireUrl;
            const applicationId = button.dataset.applicationId;

            const confirm = await Swal.fire({
                title: 'Hire candidate?',
                text: 'This will mark the candidate as hired and send out the hired email (if configured).',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Hire',
            });

            if (!confirm.isConfirmed) return;

            try {
                await axios.post(url, { _token: '{{ csrf_token() }}' });

                Swal.fire('Hired!', 'Candidate has been marked as hired.', 'success').then(() => {
                    // Update UI: add Hired badge
                    const card = document.querySelector(`[data-application-card="${applicationId}"]`);
                    if (card && !card.querySelector('.hired-badge')) {
                        const badgeRow = card.querySelector('.badge-row') || card.querySelector('.app-name');
                        const span = document.createElement('span');
                        span.className = 'hired-badge';
                        span.setAttribute('role', 'status');
                        span.setAttribute('aria-label', 'Candidate Hired');
                        span.textContent = '🎉 Hired';
                        badgeRow.appendChild(span);
                    }
                    closeAllDropdowns();
                });
            } catch (err) {
                // If API fails, try opening the route normally so your server can handle it
                window.open(url, '_blank');
            }
        });
    });
</script>

</body>
</html>
