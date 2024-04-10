import Card from '@/my-components/Card';
import { Link, Head } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);
  const [blogs, setBlogs] = useState([]);

  const [input, setInput] = useState('');
  const [description, setDescription] = useState('');
  const [blogCreated, setBlogCreated] = useState(false);

  useEffect(() => {
    fetch(`http://127.0.0.1:8000/api/blogs`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        page: currentPage,
        pager_limit: 4,
        order_direction: 'desc',
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then((data) => {
        setBlogs(data.data);
        setTotalPages(data.meta.last_page);
      })
      .catch((error) => {
        console.error(error);
      });
  }, [currentPage]);

  const handlePageChange = (page) => {
    setCurrentPage(page);
  };

  function handleSubmit(e) {
    e.preventDefault();

    if (input === '' || description === '') return;

    const authToken = JSON.parse(localStorage.getItem('access_token'));

    fetch(`http://127.0.0.1:8000/api/blogs/create`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${authToken}`,
      },
      body: JSON.stringify({
        title: input,
        text: description,
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
        setCurrentPage(1);

        setBlogCreated(true);

        setInput('');
        setDescription('');

        setTimeout(() => {
          setBlogCreated(false);
        }, 1000);
      })
      .catch((error) => {
        console.error(error);
      });
  }

  return (
    <>
      <Head title="Welcome" />
      <main className="relative p-12">
        <div className="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
          {auth.user ? (
            <Link
              href={route('dashboard')}
              className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >
              Dashboard
            </Link>
          ) : (
            <>
              <Link
                href={route('login')}
                className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
              >
                Log in
              </Link>

              <Link
                href={route('register')}
                className="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
              >
                Register
              </Link>
            </>
          )}
          `
        </div>
        <h1 className="text-center text-4xl text-white my-12">Blog</h1>
        <div className="text-white grid grid-cols-2 justify-items-center gap-8 max-w-[900px] mx-auto">
          {blogs.map((post) => (
            <Card
              key={post.id}
              id={post.id}
              title={post.title}
              description={post.text}
              author={post.author.name}
              views={post.views}
              date={post.publish_date}
              authorId={post.author.id}
              user={auth.user}
              onCurrentPage={setCurrentPage}
            />
          ))}
        </div>
        <div className="flex gap-4 mx-auto mt-16 border px-4 py-2 rounded-md">
          {Array.from({ length: totalPages }, (_, index) => index + 1).map((page) => (
            <a
              className={`text-white cursor-pointer hover:opacity-70 px-2 rounded-md ${
                currentPage === page ? 'bg-slate-400' : ''
              }`}
              key={page}
              onClick={() => handlePageChange(page)}
            >
              {page}
            </a>
          ))}
        </div>

        {auth?.user?.role === 'editor' && (
          <>
            <h2 className="text-center text-2xl text-white my-12">Create New blog</h2>
            <form
              action="#"
              onSubmit={handleSubmit}
              className="flex flex-col text-white text-xl gap-6"
            >
              <div className="flex flex-col gap-3">
                <label htmlFor="text">Title</label>
                <input
                  onChange={(e) => setInput(e.target.value)}
                  className="bg-[aliceblue] text-gray-700 rounded-sm"
                  type="text"
                  placeholder="first blog"
                  value={input}
                  required
                />
              </div>

              <div className="flex flex-col gap-3">
                <label htmlFor="content">Content</label>
                <textarea
                  onChange={(e) => setDescription(e.target.value)}
                  className="bg-[aliceblue] text-gray-700 resize-y rounded-sm"
                  name="content"
                  id="content"
                  cols="30"
                  rows="10"
                  placeholder="description"
                  value={description}
                  required
                ></textarea>
              </div>

              <button
                className={`border cursor-pointer py-4 hover:opacity-65 transition-all duration-300 ${
                  blogCreated ? 'bg-green-600' : ''
                }`}
                type="submit"
              >
                {blogCreated ? 'Blog Created' : 'Create Blog'}
              </button>
            </form>
          </>
        )}
      </main>
    </>
  );
}
