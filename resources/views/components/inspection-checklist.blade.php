<div class="container-fluid px-4 pb-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 text-primary fw-semibold">
                Checklist Inspeksi APAR
            </h5>
        </div>
        <div class="card-body">
            @forelse($questions as $question)
                <div class="mb-4">
                    <label class="fw-semibold d-block mb-2">
                        {{ $loop->iteration }}. {{ $question->question_text }}
                    </label>
                    <div class="row">
                        @foreach($question->options as $option)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input 
                                        type="radio" 
                                        name="answers[{{ $question->id }}]" 
                                        value="{{ $option->id }}" 
                                        id="question_{{ $question->id }}_option_{{ $option->id }}"
                                        class="form-check-input">
                                    <label 
                                        for="question_{{ $question->id }}_option_{{ $option->id }}" 
                                        class="form-check-label">
                                        {{ $option->option_text }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-muted">Tidak ada pertanyaan inspeksi untuk media ini.</p>
            @endforelse
        </div>
    </div>
</div>
