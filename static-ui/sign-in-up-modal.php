<?php
/**
 * this component is the modal that will "pop up" when a user elects
 * to either sign up for a profile or sign into a profile.
 * It will contain two tabs: Left will be for sign-up,
 * Right will be for sign-in
 */

<section>
   <div class="modal fade" id="sign-in-up-modal" tabindex="-2" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           ...
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           <button type="button" class="btn btn-primary">Sign Up</button>
         </div>
       </div>
     </div>
   </div>
</section>



//password field
<label for="inputPassword5">Password</label>
<input type="password" id="password" class="form-control" aria-describedby="passwordHelpBlock">
<small id="passwordHelpBlock" class="form-text text-muted">
Your password must be 8-20 characters long, contain letters, numbers, and special characters.
</small>