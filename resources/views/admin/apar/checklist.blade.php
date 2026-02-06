@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 12px;">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-0 py-3">
            <div>
                <h5 class="mb-1 fw-600">Form Checklist APAR</h5>
                <p class="mb-0 text-muted small">
                    {{ $inspection->title }} • {{ \Carbon\Carbon::parse($inspection->start_date)->format('d M Y') }}
                </p>                
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body px-4 py-3">
            <form action="#" method="POST">
                @csrf
                <input type="hidden" name="apar_id" value="{{ $aparId }}">
                <input type="hidden" name="schedule_id" value="{{ $scheduleId }}">

                <div class="question-list">
                    @foreach($questions as $question)
                        <div class="question-item mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <label class="form-label fw-semibold d-block mb-2 text-dark">
                                        {{ $loop->iteration }}. {{ $question->question_text }}
                                    </label>
                                    
                                    <div class="option-list">
                                        @foreach($question->options as $option)
                                            <div class="form-check my-2">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="question_{{ $question->id }}"
                                                       value="{{ $option->id }}"
                                                       id="q{{ $question->id }}_opt{{ $option->id }}">
                                                
                                                <label class="form-check-label d-flex align-items-center" 
                                                       for="q{{ $question->id }}_opt{{ $option->id }}">
                                                    <span class="option-bubble me-2"></span>
                                                    {{ $option->option_text }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="notes-section mt-4 mb-4">
                    <label for="notes" class="form-label fw-semibold text-dark mb-2">
                        <i class="fas fa-pencil-alt me-2"></i>Notes (Optional)
                    </label>
                    <textarea name="notes" class="form-control border-1" 
                              style="border-radius: 8px; border-color: #e0e0e0; min-height: 100px;" 
                              placeholder="Enter notes if any..."></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-2">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold" 
                            style="border-radius: 8px;">
                        <i class="fas fa-save me-2"></i>Save Checklist
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        overflow: hidden;
    }
    
    .question-item {
        transition: all 0.2s ease;
        padding: 12px 8px;
        border-radius: 8px;
    }
    
    .question-item:hover {
        background-color: #f9f9f9;
    }
    
    .option-bubble {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid #ddd;
        border-radius: 50%;
        margin-right: 8px;
        transition: all 0.2s ease;
    }
    
    .form-check-input:checked + .form-check-label .option-bubble {
        border-color: #0d6efd;
        background-color: #0d6efd;
    }
    
    .form-check-input {
        opacity: 0;
        position: absolute;
    }
    
    .form-check-label {
        cursor: pointer;
        padding-left: 0;
        user-select: none;
    }
    
    .form-check {
        padding-left: 0;
    }
</style>
@endsection