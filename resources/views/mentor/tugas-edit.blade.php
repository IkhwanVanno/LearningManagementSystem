@extends('layouts.app')

@section('title', 'Kelola Soal')

@push('styles')
    @vite('resources/css/mentor/tugas-edit.css')
@endpush

@section('content')
    <div class="tugas-edit-container">
        <div class="page-header">
            <div>
                <h1>{{ $exercise->title }}</h1>
                <p class="subtitle">{{ $exercise->classRoom->title }}</p>
            </div>
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('mentor.tugas.index') }}'">
                ← Kembali
            </button>
        </div>

        <div class="content-wrapper">
            <div class="info-card">
                <h3>Informasi Tugas</h3>
                <p><strong>Deskripsi:</strong> {{ $exercise->description }}</p>
                <p><strong>Jumlah Soal:</strong> {{ $exercise->questions->count() }} soal</p>
            </div>

            <div class="questions-section">
                <div class="section-header">
                    <h3>Daftar Soal</h3>
                    <button class="btn btn-primary btn-sm" id="btnAddQuestion">
                        + Tambah Soal
                    </button>
                </div>

                <div class="questions-list">
                    @forelse($exercise->questions as $index => $question)
                        <div class="question-item">
                            <div class="question-header">
                                <h4>Soal {{ $index + 1 }}</h4>
                                <div class="question-actions">
                                    <button class="btn-icon btn-edit" data-id="{{ $question->id }}">✏️</button>
                                    <button class="btn-icon btn-delete" data-id="{{ $question->id }}">🗑️</button>
                                </div>
                            </div>
                            <div class="question-body">
                                <p class="question-text">{{ $question->question_text }}</p>
                                <div class="options">
                                    <div class="option {{ $question->correct_answer === 'A' ? 'correct' : '' }}">
                                        <strong>A.</strong> {{ $question->option_a }}
                                    </div>
                                    <div class="option {{ $question->correct_answer === 'B' ? 'correct' : '' }}">
                                        <strong>B.</strong> {{ $question->option_b }}
                                    </div>
                                    <div class="option {{ $question->correct_answer === 'C' ? 'correct' : '' }}">
                                        <strong>C.</strong> {{ $question->option_c }}
                                    </div>
                                    <div class="option {{ $question->correct_answer === 'D' ? 'correct' : '' }}">
                                        <strong>D.</strong> {{ $question->option_d }}
                                    </div>
                                </div>
                                <p class="correct-indicator">✓ Jawaban benar: {{ $question->correct_answer }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <p>Belum ada soal. Klik "Tambah Soal" untuk membuat soal baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit Question -->
    <div id="questionModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Soal</h2>
                <span class="close" id="btnCloseModal">&times;</span>
            </div>

            <form id="questionForm">
                @csrf
                <input type="hidden" id="questionId" name="question_id">
                <input type="hidden" id="formMethod" value="POST">
                <input type="hidden" name="exercise_id" value="{{ $exercise->id }}">

                <div class="form-group">
                    <label for="question_text">Pertanyaan <span class="required">*</span></label>
                    <textarea id="question_text" name="question_text" rows="3" required></textarea>
                    <span class="error-message" id="error-question_text"></span>
                </div>

                <div class="form-group">
                    <label for="option_a">Pilihan A <span class="required">*</span></label>
                    <input type="text" id="option_a" name="option_a" required>
                    <span class="error-message" id="error-option_a"></span>
                </div>

                <div class="form-group">
                    <label for="option_b">Pilihan B <span class="required">*</span></label>
                    <input type="text" id="option_b" name="option_b" required>
                    <span class="error-message" id="error-option_b"></span>
                </div>

                <div class="form-group">
                    <label for="option_c">Pilihan C <span class="required">*</span></label>
                    <input type="text" id="option_c" name="option_c" required>
                    <span class="error-message" id="error-option_c"></span>
                </div>

                <div class="form-group">
                    <label for="option_d">Pilihan D <span class="required">*</span></label>
                    <input type="text" id="option_d" name="option_d" required>
                    <span class="error-message" id="error-option_d"></span>
                </div>

                <div class="form-group">
                    <label for="correct_answer">Jawaban Benar <span class="required">*</span></label>
                    <select id="correct_answer" name="correct_answer" required>
                        <option value="">Pilih Jawaban</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                    <span class="error-message" id="error-correct_answer"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelModal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/mentor/tugas-edit.js')
@endpush