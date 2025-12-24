@extends('layouts.app')

@section('title', 'Kerjakan Tugas')

@push('styles')
    @vite('resources/css/student/tugas-kerjakan.css')
@endpush

@section('content')
    <div class="kerjakan-container">
        <div class="page-header">
            <div>
                <h1>{{ $exercise->title }}</h1>
                <p class="subtitle">{{ $exercise->classRoom->title }}</p>
            </div>
            <button class="btn btn-secondary" onclick="confirmBack()">
                ← Kembali
            </button>
        </div>

        <!-- Exercise Info -->
        <div class="card exercise-info-card">
            <div class="card-body">
                <div class="info-row">
                    <div class="info-item">
                        <strong>Deskripsi:</strong>
                        <p>{{ $exercise->description }}</p>
                    </div>
                    <div class="info-item">
                        <strong>Jumlah Soal:</strong>
                        <p>{{ $exercise->questions->count() }} soal</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Form -->
        <form id="quizForm">
            @csrf
            <div class="questions-container">
                @foreach($exercise->questions as $index => $question)
                    <div class="question-card" data-question="{{ $index + 1 }}">
                        <div class="question-header">
                            <h3>Soal {{ $index + 1 }}</h3>
                            <span class="question-indicator" id="indicator-{{ $question->id }}">
                                Belum Dijawab
                            </span>
                        </div>

                        <div class="question-body">
                            <p class="question-text">{{ $question->question_text }}</p>

                            <div class="options">
                                <label class="option-label">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="A"
                                        data-question-id="{{ $question->id }}" required>
                                    <span class="option-content">
                                        <strong>A.</strong> {{ $question->option_a }}
                                    </span>
                                </label>

                                <label class="option-label">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="B"
                                        data-question-id="{{ $question->id }}" required>
                                    <span class="option-content">
                                        <strong>B.</strong> {{ $question->option_b }}
                                    </span>
                                </label>

                                <label class="option-label">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="C"
                                        data-question-id="{{ $question->id }}" required>
                                    <span class="option-content">
                                        <strong>C.</strong> {{ $question->option_c }}
                                    </span>
                                </label>

                                <label class="option-label">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="D"
                                        data-question-id="{{ $question->id }}" required>
                                    <span class="option-content">
                                        <strong>D.</strong> {{ $question->option_d }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Progress Info -->
            <div class="progress-card">
                <div class="progress-info">
                    <span>Progress:</span>
                    <span id="progressText">0 / {{ $exercise->questions->count() }}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progressBar"></div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="submit-section">
                <button type="button" class="btn btn-primary btn-lg" id="submitBtn">
                    Kumpulkan Jawaban
                </button>
            </div>
        </form>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Konfirmasi Pengumpulan</h2>
            </div>
            <div class="modal-body">
                <p>Anda telah menjawab <strong id="answeredCount">0</strong> dari
                    <strong>{{ $exercise->questions->count() }}</strong> soal.
                </p>
                <p class="warning-text">Setelah dikumpulkan, Anda tidak dapat mengubah jawaban. Apakah Anda yakin?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelSubmit">Cek Lagi</button>
                <button type="button" class="btn btn-primary" id="btnConfirmSubmit">Ya, Kumpulkan</button>
            </div>
        </div>
    </div>

    <!-- Result Modal -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Hasil Pengerjaan</h2>
            </div>
            <div class="modal-body">
                <div class="result-summary">
                    <div class="result-icon">
                        <span id="resultEmoji">🎉</span>
                    </div>
                    <h3>Nilai Anda</h3>
                    <p class="result-score" id="finalScore">0</p>
                    <div class="result-details">
                        <p>Benar: <strong id="correctCount">0</strong></p>
                        <p>Salah: <strong id="wrongCount">0</strong></p>
                        <p>Total: <strong>{{ $exercise->questions->count() }}</strong></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="window.location.href='/student/tugas'">
                    Kembali ke Daftar Tugas
                </button>
            </div>
        </div>
    </div>

    <script>
        const exerciseId = {{ $exercise->id }};
        const totalQuestions = {{ $exercise->questions->count() }};
    </script>
@endsection

@push('scripts')
    @vite('resources/js/student/tugas-kerjakan.js')
@endpush