# Workout API

The Workout API is designed to track workouts that I've been doing for the past few years. There's an accompanying web application that manages all of the user facing interactions --- user login and exercise tracking during workouts --- that works in collaboration with the API. The API has been designed to model the workout data that is required to log and track my exercies. 

# Nginx setup

To route the API through the URI, like `workout.dev/api`, place the following in the nginx config server block.

```
location /api {
    try_files $uri $uri/ /api/index.php?query_string;
}

location / {
    try_files $uri $uri/ /index.php?query_string;
}
```

# API

This API communicates in JSON and attepts to respond in a RESTful way.

### Status codes

Code | Message
---- | -------
200  | GET, PUT, or PATCH Success
201  | POST Success
204  | DELETE Success
400  | Bad request
401  | Unauthorized
403  | Forbidden
404  | Not found
422  | Unprocessable Entity
500  | Internal Server Error

### POST /login

Authenticate a user login request by returning a success or failure code.

#### Request

```
{
    'user': 'admin@localhost.com',
    'password': 'password123'
}
```

#### Response

Success code: 201

Form validation failure: 422

Failure code: 401

### POST /logout

Invalidate a user sessions.

#### Request

No extra data needed. In browsers, the cookie will be send automatically.

#### Response

Success code: 204

### GET /auth

Verify that a cookie is valid and matches the user creds.

#### Request

No extra data needed. In browsers, the cookie will be send automatically.

#### Response

Success code: 200

Failure code: 401


### GET /exercises

Return a list of all exercises and their default values.

#### Request

No extra data needed.

#### Response

Success code: 200

Body: a list of exercises

```
[
    {"id":"1","title":"Warm Up","default_sets":"1","default_reps":"1","wait_time":"0","category":"warm"},
    {"id":"2","title":"Pull Ups","default_sets":"2","default_reps":"5","wait_time":"60","category":"pull"},
    ...
]
```

### GET /version

Return the current version of the API. Good for a quick ping to make sure everything is okay.

#### Request

No extra data needed.

#### Response

Success code: 200

Body: the current version of the API 

```
{'version': "1.0"}
```

### POST /workouts/new

Add a new workout that a user has completed.

#### Request

```
{
    'start': null,
    'end': null,
    'notes': null,
    'feel': null,
    'exercises': [
        {
            'exercise_type_id': null,
            'sets': null,
            'reps': [
                {
                    'amount': null
                },
                {
                    'amount': null
                },
            ],
            'feedback': null
        },
        {
            'exercise_type_id': null,
            'sets': null,
            'reps': [
                {
                    'amount': null
                },
                {
                    'amount': null
                },
            ],
            'feedback': null
        },
        ...
    ]
}
```

#### Response

Success code: 201

Form validation failure: 422

Failure code: 400

