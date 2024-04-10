export default function Card({
  title,
  description,
  author,
  views,
  date,
  id,
  user,
  onCurrentPage,
  authorId,
}) {
  function handleClick(event) {
    event.preventDefault();

    fetch(`http://127.0.0.1:8000/api/blogs/view/${id}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
    })
      .then((response) => response.json())
      .then((data) => {
        window.location.href = `/blogs/${id}`;
      })
      .catch((error) => {
        console.error('Error:', error);
      });
  }

  function handleDelete() {
    const authToken = JSON.parse(localStorage.getItem('access_token'));

    fetch(`http://127.0.0.1:8000/api/blogs/delete/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${authToken}`,
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then((data) => {
        onCurrentPage(1);
      })
      .catch((error) => {
        console.error(error);
      });
  }

  return (
    <div className="relative w-96 bg-blue-800 p-4 rounded-xl pb-36">
      <h2 className="text-2xl font-bold mt-4">{title}</h2>
      <p className="text-md mt-4">{description}</p>
      <p className="text-sm absolute bottom-16 mt-4 text-gray-400">{date}</p>
      <p className="text-md absolute bottom-10 mt-4 text-gray-300">Author: {author}</p>
      <div className="absolute right-2 top-2 flex gap-2 items-center">
        <p className="text-gray-300">Views: {views}</p>
        {(user?.role === 'admin' || authorId === user?.id) && (
          <svg
            xmlns="http://www.w3.org/2000/svg"
            className="ionicon size-5 text-red-700 cursor-pointer hover:opacity-65"
            viewBox="0 0 512 512"
            onClick={handleDelete}
          >
            <path
              d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320"
              fill="none"
              stroke="currentColor"
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth="32"
            />
            <path
              stroke="currentColor"
              strokeLinecap="round"
              strokeMiterlimit="10"
              strokeWidth="32"
              d="M80 112h352"
            />
            <path
              d="M192 112V72h0a23.93 23.93 0 0124-24h80a23.93 23.93 0 0124 24h0v40M256 176v224M184 176l8 224M328 176l-8 224"
              fill="none"
              stroke="currentColor"
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth="32"
            />
          </svg>
        )}
      </div>
      <a
        onClick={handleClick}
        className="absolute text-center left-2 bottom-2 right-2 bg-red-900 rounded-xl hover:opacity-70 transition-all duration-150 cursor-pointer"
      >
        See More
      </a>
    </div>
  );
}
