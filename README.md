# ChorePro

ChorePro is an application used to randomly allocate the chores that need to be assigned across multiple people in a household.

Users can register accounts on the website where their password is securely stored in hashed form (using a salt) in the database. They can then login to their accounts and view their current chores, create housholds, view their fellow members chores, view the weather,  join a household of their choice, upload a profile picture, get notified for any new chore assignments and many more.

## Features

-   Users can register accounts on the website and then login to their account by using their name, email , password.
-   User passwords are securely stored as a hash with salting and a user authentication is provided.
-   Adding a chore including their name, description, frequency (every day, every week, every fortnight one time)
-   Chores are splitted between housemates, where a random allocation is peromed.
-   Bills can be viewed, showing the status of the bill, the total amount required, the payments required, the user that created the bill and any comments made by the biller.
-   Marking chores complete by the housemate.
-   Displaying the status of chores.
-   Notification of user’s active chore and the deadline date

## Additional Features

-   Error messages and success added for every input field.
-   Ajax is utilized through the website. The chores are removed and updated using ajax. The owner is able to remove the users with ajax as well.
-   Extra security layers in the form sections (modifyhousehold) which are disabled for non authorized users but only for the owner of the household. Only the owner is able to modify the household. When no household is detected then it's completely disabled
-   A responsive design that displays the web application correctly on mobile browsers, tablets, etc.
-  The owner is able to remove members from their households
-  A unique 5 characters join ID is produced for each house adding an extra layer of security
-  The members webpage enables users to see the other members of their households along with their profile picture
-  The owner is able to modify the details of his household
-  A notification bell for notifications was added which is able to detect whether the Users have already read their notifications
- Th login page has the toggle password eye feature for users that make often mistakes. That should include disabled people who have moving issues and having a higher error rate
- An account settings is included
- The user is able to modify their names, emails, password, join a household
- The user is able to delete their account. The  system detects whether is an owner of a household and deletes the household along with its chores
- Weather widget was added on the homepage
- Icons were added to make a more pleasant experience
- Added chores for multiple people
- The user can upload a profile picture using ajax. Their displayed using js
- The user has an option to remove his/her profile picture and an avatar takes place
- The images are stored using the user's hashed email verification token since mysql was not allowed
- Email verification is performed using a hashed token
- The login page performs a check to see whether the email was verified or not
- The page intelligently counts the days left for a chore. The icludes for recurring chores that were marked as completed. When the deadline is passed the days are marked as zero. If it's a recurring chore and the deadline was passed then page recalculates the days left
- Notifications are displayed when a member joins a household
- The users are able to see their household's assigned chores
- The user are able to create their own households
- The page detects whether the user was in household and removes their shores along their past household if they were owners
- The dashboard where it displays the chores and the notifications are refreshed using ajax.
- The forms that require the user to modify their data have already the old values.
- The verification email contains styled html
- Circled cutout for adding a profile picture without exposing any upload buttons but instead showing up when entered the area
-
## Libraries Used
Used for icons
https://kit.fontawesome.com/6b23de7647.js
Jquery
https://code.jquery.com/jquery-3.4.1.min.js
font
https://fonts.googleapis.com/css?family=Open+Sans:300,400
Used for icons
https://use.fontawesome.com/releases/v5.4.1/css/all.css-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz
