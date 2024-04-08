# Introduction to Workout App

The Workout App aims to assist you in tracking and charting your workout progress over time. The collaboration between the App and its accompanying API enables seamless management and tracking of user data and exercises.

## Understanding The App Structure

### API Details

The API, programmed in PHP, resides in the `/api` folder, which is at the root of the application. It serves as a central handler for user and exercise data and plays an integral part in the app's functioning.

### User Interface and Navigation

Our user interface is clean and straightforward, ensuring easy navigation through different pages.

#### Authentication - Login Page

The app initiates at the Login Page ('/'), which authenticates your/user credentials before granting access to further app functionalities such as the Workout page.

#### Workout Tracking - Workout Page

The workout page (`/go`) stands at the core of the app's functionality. It not only allows you to compose a workout using available exercises but also effectively runs the workout, thereby making your workout experience smooth and personalized.
