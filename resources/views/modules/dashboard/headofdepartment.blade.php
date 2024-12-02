<style>
    .welcome-message {
        text-align: center;
        padding: 2rem;
    }

    .quote-box {
        max-width: 800px;
        margin: 0 auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .blockquote {
        font-size: 1.25rem;
        font-style: italic;
    }
</style>
@extends('layouts.backend.app')
@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-body px-4 py-4-5">
        <div class="welcome-message">
            <h2 class="mb-4">Selamat Datang, {{ $username->name }}!</h2>

            <div class="quote-box mt-4 p-4 bg-light rounded">
                <blockquote class="blockquote">
                    <p class="mb-2" id="random-quote">Loading quote...</p>
                    <footer class="blockquote-footer" id="quote-author"></footer>
                </blockquote>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const options = {
            method: 'GET',
            headers: {
                'X-Api-Key': 'd2bv/vQ/iIdO/I9ixeP6wQ==geJjicWFuokvYQYb'
            }
        };

        fetch('https://api.api-ninjas.com/v1/quotes?category=success', options)
            .then(response => response.json())
            .then(data => {
                if (data && data[0]) {
                    document.getElementById("random-quote").textContent = data[0].quote;
                    document.getElementById("quote-author").textContent = data[0].author;
                }
            })
            .catch(error => {
                document.getElementById("random-quote").textContent = "Success is not final, failure is not fatal: it is the courage to continue that counts.";
                document.getElementById("quote-author").textContent = "Winston Churchill";
            });
    });
</script>
