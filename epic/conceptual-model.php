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
            <li>recAreaDescription</li>
            <li>recAreaDirections</li>
				<li>recAreaImgUrl</li>
            <li>recAreaLat</li>
            <li>recAreaLong</li>
				<li>recAreaMap</li>
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
         <ul>Review
            <li>reviewId (Primary Key)</li>
            <li>reviewRecAreaId (Foreign Key)</li>
            <li>reviewProfileId (Foreign Key)</li>
            <li>reviewContent</li><!--make this nullable-->
            <li>reviewDateTime</li>
            <li>reviewRating</li>
         </ul>
         <ul>Activity<!--innummerator-->
            <li>activityId (Primary Key)</li>
            <li>activityName</li>
         </ul>
         <ul>ActivityType (weak entity)<!--bridge-->
				<li>activityTypeActivityId (Foreign Key)</li>
				<li>activityTypeRecId (Foreign Key)</li>
         </ul>
      </div>
      <div>
         <ul>Relationships
				<li>Many profiles can review many rec areas (m-to-n)</li>
				<li>Many rec areas can have many activity types (m-to-n)</li>
			</ul>
      </div>
      <div class="fixed-footer">
         <div class="container"><a href="./index.html">Home</a></div>
      </div>
   </body>
</html>