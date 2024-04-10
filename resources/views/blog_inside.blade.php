<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    </head>
    <body class="antialiased">
        <div data-id="{{ $id }}" class="container">
            <h1 class="heading">{{ $row['title'] }}</h1>
            <div class="author-wrapper">
                <p>Author: {{ $row->author['name'] }}</p>
                <div class="view-wrapper">
                    <p class="views">Views: {{ $row['views'] }}</p>
                    <p>{{ $row['publish_date'] }}</p>
                </div>
            </div>
            <p>{{ $row['text'] }}</p>

            @if(auth()->user() && ($role == \App\Enums\Role::editor && $userId == $row->author['id']))
                <h2 class="blogHeading">Edit blog</h2>
                <form
                action="#"
                class="formWrapper"
                >
                <div class="inputWrapper">
                    <label for="text">Title</label>
                    <input
                    class="editInput"
                    type="text"
                    placeholder="first blog"
                    value="{{ $row['title'] }}"
                    required
                    />
                </div>

                <div class="inputWrapper">
                    <label for="content">Content</label>
                    <textarea
                    class="editTextArea"
                    name="content"
                    id="content"
                    cols="30"
                    rows="10"
                    placeholder="description"
                    required
                    >{{ $row['text'] }}</textarea>
                </div>

                <button
                    class="editButton"
                    type="submit"
                >
                    Edit Blog
                </button>
                </form>
            @endif
            

            <div class="comments-wrapper">
                <h2 class="comment-heading">Comments</h2>
                <hr class="hr">
                @if(auth()->user() && $role == \App\Enums\Role::user)
                    <form class="form">
                        <input type="text" class="comment-input" placeholder="Join the discussion">
                    </form>
                @endif
                @if(!empty($row->comments))
                    @foreach ($row->comments as $comment)
                        <div class="comment-container">
                            <div class="name-wrapper">
                                <p class="author">
                                    {{ $comment->user['name'] }}
                                </p>
                                <p class="date">
                                    {{ $comment->created_at }}
                                </p>

                                @if(auth()->user() && ($role == \App\Enums\Role::admin || ($role == \App\Enums\Role::user && $userId == $comment->user_id)))
                                    <p data-value="{{ $comment->id }}" class="delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon icon" viewBox="0 0 512 512"><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352"/><path d="M192 112V72h0a23.93 23.93 0 0124-24h80a23.93 23.93 0 0124 24h0v40M256 176v224M184 176l8 224M328 176l-8 224" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                                    </p>
                                @endif
                            </div>
                            <p>
                                {{ $comment->text }}
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </body>

    <style>

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: rgb(17 24 39);
            font-family: sans-serif;
            padding: 30px 10px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            color: white;
        }

        .heading {
            text-align: start;
            font-size: 40px;
            margin-bottom: 20px;
        }

        .author-wrapper {
            display: flex;
            flex-direction: column;
            color: rgb(209 213 219);
            margin-bottom: 50px;
            font-size: 14px;
        }

        .view-wrapper {
            display: flex;
            gap: 10px;
            color: rgb(209 213 219);
        }

        .comments-wrapper {
            padding: 30px;
            background-color: aliceblue;
            color: #393939;
            margin: 40px 0;
        }

        .comment-heading {
            margin-bottom: 20px;
        }

        .comment-input {
            margin-top: 20px;
            padding: 10px 20px;
            width: 100%;
            font-size: 16px;
        }

        .comment-container {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin: 30px 0;
        }

        .name-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .author {
            color: #1e73be;
        }

        .date {
            font-size: 11px;
            color: #393939;
        }

        .delete {
            cursor: pointer;
        }

        .icon {
            width: 20px;
            height: 20px;
        }

        .formWrapper {
            display: flex; 
            flex-direction: column; 
            gap: 1.5rem; 
            font-size: 1.25rem;
            line-height: 1.75rem; 
            color: #ffffff; 
            margin-bottom: 150px;
        }

        .inputWrapper {
            display: flex; 
            flex-direction: column; 
            gap: 0.75rem; 
        }

        .blogHeading {
            margin-top: 100px;
            margin-bottom: 6px; 
            font-size: 1.5rem;
            line-height: 2rem; 
            text-align: center; 
            color: #ffffff; 
        }

        .editInput {
            border-radius: 0.125rem; 
            color: #374151; 
            background: aliceblue;
            padding: 10px;
            font-size: 16px;
        }

        .editTextArea {
            border-radius: 0.125rem; 
            color: #374151; 
            resize: vertical; 
            background: aliceblue;
            padding: 10px;
            font-size: 16px;
        }

        .editButton {
            padding-top: 1rem;
            padding-bottom: 1rem; 
            border-width: 1px; 
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms; 
            transition-duration: 300ms; 
            cursor: pointer; 
        }

        .editButton:hover {
            opacity: 70;
        }

    </style>

    <script>
        const deleteBtns = document.querySelectorAll(".delete");
        const authToken = JSON.parse(localStorage.getItem('access_token'));

        deleteBtns.forEach(element => {
            element.addEventListener("click", () => {
                const commentContainer = element.closest('.comment-container');

                if (commentContainer) {
                    commentContainer.remove();
                }

                const id = element.dataset.value;

                fetch(`http://127.0.0.1:8000/api/comments/delete/${id}`, {
                    method: "DELETE",
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${authToken}`,
                    },
                }).then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                        return response.json();
                    })
                    .then((data) => {
                        console.log(data);
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            })
        });

        const form = document.querySelector(".form");
        const input = document.querySelector(".comment-input");
        const container = document.querySelector(".container");

        if (input) {
            form.addEventListener("submit", (event) => {
                event.preventDefault();
                
                fetch("http://127.0.0.1:8000/api/comments/create", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${authToken}`,
                    },
                    body: JSON.stringify({
                        blog_id: container.dataset.id,
                        text: input.value
                    }),
                })
    
                input.value = "";
    
                setTimeout(() => {
                    location.reload();
                }, 500);
                
            });
        }

        const editForm = document.querySelector(".formWrapper");
        const editInput = document.querySelector(".editInput");
        const editText = document.querySelector(".editTextArea");

        if (editForm) {
            editForm.addEventListener("submit", (e) => {
                e.preventDefault();

                fetch(`http://127.0.0.1:8000/api/blogs/update/${container.dataset.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${authToken}`,
                    },
                    body: JSON.stringify({
                        title: editInput.value,
                        text: editText.value,
                        publish_date: null,
                    }),
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        
                        return response.json();
                    })
                    .then((data) => {

                    })
                    .catch((error) => {
                        console.error(error);
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 500);
            })
        }

    </script>

</html>
