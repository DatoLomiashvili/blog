import classes from "./Pagination.module.css";
import { Link } from "react-router-dom";

const ARCHIVE_DATA = {
  "data": [
    {
      "id": 3,
      "title": "blog3",
      "text": "teeeeet",
      "views": 0,
      "author": "Davit Lomiashvili",
      "publish_date": "2025-04-09 09:13:02",
      "created_at": null
    },
    {
      "id": 4,
      "title": "New Title",
      "text": "neeew",
      "views": 0,
      "author": "Dato",
      "publish_date": "2024-04-09 15:20:39",
      "created_at": "2024-04-09T15:19:25.000000Z"
    },
    {
      "id": 1,
      "title": "blog1",
      "text": "teeeeet",
      "views": 3,
      "author": "Davit Lomiashvili",
      "publish_date": "2024-04-09 09:13:02",
      "created_at": null
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/blogs?page=1",
    "last": "http://127.0.0.1:8000/api/blogs?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://127.0.0.1:8000/api/blogs?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "http://127.0.0.1:8000/api/blogs",
    "per_page": 6,
    "to": 3,
    "total": 3
  }
}

const total = ARCHIVE_DATA.meta.total

export default function Pagination({ id, currentPaginationNumbers }) {
  function disablePrevious(e) {
    if (id === 1) {
      e.preventDefault();
    } else {
      window.scrollTo(0, 0);
    }
  }

  function disableButtons(e) {
    if (e.target.textContent > Math.ceil(total / 6)) {
      e.preventDefault();
    } else {
      window.scrollTo(0, 0);
    }
  }

  function disableNext(e) {
    if (id + 1 > Math.ceil(total / 6)) {
      e.preventDefault();
    } else {
      window.scrollTo(0, 0);
    }
  }

  return (
    <div className={classes.pagination}>
      <ul className={classes.paginationUl}>
        <Link
          onClick={disablePrevious}
          to={`/news/page-${id - 1}`}
          className={`${classes.paginationLi} ${classes.previous} ${
            id === 1 ? classes.disabled : ""
          }`}
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            strokeWidth="1.5"
            stroke="currentColor"
            className={classes.icon}
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              d="M15.75 19.5L8.25 12l7.5-7.5"
            />
          </svg>
          წინა
        </Link>
        {currentPaginationNumbers.map((el) => (
          <Link
            onClick={disableButtons}
            key={el}
            to={`/news/page-${el}`}
            className={`${classes.paginationLi} ${
              id === el ? classes.active : ""
            } ${
              el > Math.ceil(total / 6) ? classes.disabled : ""
            }`}
          >
            {el}
          </Link>
        ))}
        <Link
          onClick={disableNext}
          to={`/news/page-${id + 1}`}
          className={`${classes.paginationLi} ${classes.next} ${
            id + 1 > Math.ceil(total / 6) ? classes.disabled : ""
          }`}
        >
          შემდეგი
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            strokeWidth="1.5"
            stroke="currentColor"
            className={classes.icon}
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              d="M8.25 4.5l7.5 7.5-7.5 7.5"
            />
          </svg>
        </Link>
      </ul>
    </div>
  );
}
