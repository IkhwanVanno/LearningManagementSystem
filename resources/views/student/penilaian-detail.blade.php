@extends('layouts.app')

@section('title', 'Detail Penilaian')

@push('styles')
    @vite('resources/css/student/penilaian-detail.css')
@endpush

@section('content')
    <div class="penilaian-detail-container">
        <div class="page-header">
            <div>
                <h1>{{ $result->exercise->title }}</h1>
                <p class="subtitle">{{ $result->exercise->classRoom->title }}</p>
            </div>
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('student.penilaian.index') }}'">
                ← Kembali
            </button>
        </div>

        <!-- Result Summary -->
        <div class="result-summary-card">
            <div class="summary-header">
                <h2>Hasil Pengerjaan</h2>
                <span class="submission-date">{{ $result->submitted_at->format('d M Y H:i') }}</span>
            </div>
            <div class="summary-body">
                <div class="summary-item">
                    <div class="summary-label">Nilai</div>
                    <div class="summary-value score-{{ $result->score >= 70 ? 'good' : 'poor' }}">
                        {{ $result->score ?? 'Belum Dinilai' }}
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Benar</div>
                    <div class="summary-value">
                        {{ $studentAnswers->where('is_correct', true)->count() }}
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Salah</div>
                    <div class="summary-value">
                        {{ $studentAnswers->where('is_correct', false)->count() }}
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Total Soal</div>
                    <div class="summary-value">
                        {{ $result->exercise->questions->count() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Review -->
        <div class="questions-review">
            <h2>Review Jawaban</h2>

            @foreach($result->exercise->questions as $index => $question)
                @php
                    $studentAnswer = $studentAnswers->get($question->id);
                    $isCorrect = $studentAnswer && $studentAnswer->is_correct;
                @endphp

                <div class="review-card {{ $isCorrect ? 'correct' : 'incorrect' }}">
                    <div class="review-header">
                        <h3>Soal {{ $index + 1 }}</h3>
                        <span class="result-badge {{ $isCorrect ? 'badge-correct' : 'badge-incorrect' }}">
                            {{ $isCorrect ? '✓ Benar' : '✗ Salah' }}
                        </span>
                    </div>

                    <div class="review-body">
                        <p class="question-text">{{ $question->question_text }}</p>

                        <div class="options-review">
                            <div
                                class="option-review {{ $question->correct_answer == 'A' ? 'option-correct' : '' }} {{ $studentAnswer && $studentAnswer->selected_answer == 'A' && !$isCorrect ? 'option-wrong' : '' }}">
                                <strong>A.</strong> {{ $question->option_a }}
                                @if($question->correct_answer == 'A')
                                    <span class="option-indicator">✓ Jawaban Benar</span>
                                @endif
                                @if($studentAnswer && $studentAnswer->selected_answer == 'A' && !$isCorrect)
                                    <span class="option-indicator wrong">✗ Jawaban Anda</span>
                                @endif
                            </div>

                            <div
                                class="option-review {{ $question->correct_answer == 'B' ? 'option-correct' : '' }} {{ $studentAnswer && $studentAnswer->selected_answer == 'B' && !$isCorrect ? 'option-wrong' : '' }}">
                                <strong>B.</strong> {{ $question->option_b }}
                                @if($question->correct_answer == 'B')
                                    <span class="option-indicator">✓ Jawaban Benar</span>
                                @endif
                                @if($studentAnswer && $studentAnswer->selected_answer == 'B' && !$isCorrect)
                                    <span class="option-indicator wrong">✗ Jawaban Anda</span>
                                @endif
                            </div>

                            <div
                                class="option-review {{ $question->correct_answer == 'C' ? 'option-correct' : '' }} {{ $studentAnswer && $studentAnswer->selected_answer == 'C' && !$isCorrect ? 'option-wrong' : '' }}">
                                <strong>C.</strong> {{ $question->option_c }}
                                @if($question->correct_answer == 'C')
                                    <span class="option-indicator">✓ Jawaban Benar</span>
                                @endif
                                @if($studentAnswer && $studentAnswer->selected_answer == 'C' && !$isCorrect)
                                    <span class="option-indicator wrong">✗ Jawaban Anda</span>
                                @endif
                            </div>

                            <div
                                class="option-review {{ $question->correct_answer == 'D' ? 'option-correct' : '' }} {{ $studentAnswer && $studentAnswer->selected_answer == 'D' && !$isCorrect ? 'option-wrong' : '' }}">
                                <strong>D.</strong> {{ $question->option_d }}
                                @if($question->correct_answer == 'D')
                                    <span class="option-indicator">✓ Jawaban Benar</span>
                                @endif
                                @if($studentAnswer && $studentAnswer->selected_answer == 'D' && !$isCorrect)
                                    <span class="option-indicator wrong">✗ Jawaban Anda</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection