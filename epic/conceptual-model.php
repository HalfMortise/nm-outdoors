<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Conceptual Model</title>
      <link rel="stylesheet" href="./style.css">
   </head>
   <body>
      <h3>Entities & Attributes</h3>
      <div>
         <ul>RecArea
            <li>recAreaId (Primary Key)</li>
            <li>recAreaAddress</li>
            <li>recAreaDescription</li>
            <li>recAreaDirections</li>
            <li>recAreaLat</li>
            <li>recAreaLocation</li>
            <li>recAreaLong</li>
            <li>recAreaName</li>
         </ul>
         <ul>Profile
            <li>profileId (Primary Key)</li>
            <li>profileActivationToken</li>
            <li>profileEmail</li>
            <li>profileHash</li>
            <li>profileImage</li>
            <li>profileAtHandle</li>
         </ul>
         <ul>Favorite (weak entity)
            <li>favProfileId (Foreign Key)</li>
            <li>favProfileRecAreaId (Foreign Key)</li>
         </ul>
         <ul>Review
            <li>reviewId (Primary Key)</li>
            <li>reviewRecAreaId (Foreign Key)</li>
            <li>reviewProfileId (Foreign Key)</li>
            <li>reviewContent</li>
            <li>reviewDateTime</li>
            <li>reviewRating</li>
         </ul>
         <ul>Activity
            <li>activityId (Primary Key)</li>
            <li>activityRecAreaId (Foreign Key)</li>
         </ul>
         <ul>ActivityType
            <li>activityTypeId (Primary Key)</li>
            <li>activityTypeName (Foreign Key)</li>
         </ul>
      </div>
      <div>
         <ul>Relationships (TBA)
            <li></li>
            <li></li>
         </ul>
      </div>
      <div class="fixed-footer">
         <div class="container"><a href="./index.html">Home</a></div>
      </div>
   </body>
</html>