@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>{{ $note->title }}</h2>

    <div class="mb-3">
        <textarea class="form-control" id="noteContent" rows="10" readonly>{{ $note->content }}</textarea>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary" id="summarizeBtn">
            <span id="btnText">Summarize with AI</span>
            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"></span>
        </button>

        <button class="btn btn-info" id="wordCountBtn">
            <span id="wordCountBtnText">Show Word Count</span>
            <span id="wordCountSpinner" class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"></span>
        </button>
    </div>

    <div id="summarySection" class="mt-4" style="display: none;">
        <h4>AI Summary:</h4>
        <div class="border rounded p-3 bg-light" id="summaryResult"></div>
    </div>

    <div id="wordCountSection" class="mt-4" style="display: none;">
        <h4>Word Count:</h4>
        <div class="border rounded p-3 bg-light" id="wordCountResult"></div>
    </div>
</div>

<script>
    // AI Summarization (Laravel)
    document.getElementById('summarizeBtn').addEventListener('click', async function () {
        const btn = this;
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const content = document.getElementById('noteContent').value.trim();
        const resultDiv = document.getElementById('summaryResult');
        const summarySection = document.getElementById('summarySection');

        if (!content) {
            alert('Note content is empty!');
            return;
        }

        btn.disabled = true;
        btnText.textContent = 'Summarizing...';
        btnSpinner.classList.remove('d-none');
        summarySection.style.display = 'block';
        resultDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <strong>Loading summary...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        `;

        try {
            const response = await fetch('{{ route('ai.summarize') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ content })
            });

            let data;
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            data = await response.json();

            if (data.summary) {
                resultDiv.textContent = data.summary;
            } else if (data.error) {
                resultDiv.innerHTML = `<span class="text-danger">Error: ${data.error}</span>`;
            } else {
                resultDiv.innerHTML = '<span class="text-warning">No summary returned.</span>';
            }

            summarySection.scrollIntoView({ behavior: 'smooth' });

        } catch (error) {
            resultDiv.innerHTML = '<span class="text-danger">Error generating summary.</span>';
            console.error('Fetch error:', error);
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Summarize with AI';
            btnSpinner.classList.add('d-none');
        }
    });

    // Word Count functionality
    document.getElementById('wordCountBtn').addEventListener('click', async function () {
        const btn = this;
        const btnText = document.getElementById('wordCountBtnText');
        const btnSpinner = document.getElementById('wordCountSpinner');
        const content = document.getElementById('noteContent').value.trim();
        const resultDiv = document.getElementById('wordCountResult');
        const wordCountSection = document.getElementById('wordCountSection');

        if (!content) {
            alert('Note content is empty!');
            return;
        }

        btn.disabled = true;
        btnText.textContent = 'Calculating...';
        btnSpinner.classList.remove('d-none');
        wordCountSection.style.display = 'block';
        resultDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <strong>Calculating word count...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        `;

        try {
            const response = await fetch('/raw_wordcount.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content })
            });

            if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
            const data = await response.json();

            if (data.word_count !== undefined) {
                resultDiv.textContent = `Word count: ${data.word_count}`;
            } else if (data.error) {
                resultDiv.innerHTML = `<span class="text-danger">Error: ${data.error}</span>`;
            } else {
                resultDiv.innerHTML = `<span class="text-warning">Unexpected response.</span>`;
            }

            wordCountSection.scrollIntoView({ behavior: 'smooth' });

        } catch (error) {
            console.error('Fetch error:', error);
            resultDiv.innerHTML = `<span class="text-danger">Error contacting word count service.</span>`;
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Show Word Count';
            btnSpinner.classList.add('d-none');
        }
    });
</script>
@endsection
