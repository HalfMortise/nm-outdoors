/******************************************************************************************************/
/*	Module name: profile.component.ts																							*/
/* Module description: Behind-the-curtain components populating the front-end of the user's profile		*/
/*	Author: HalfMortise																											*/
/*	Date: 9/7/2018																													*/
/******************************************************************************************************/

/* Imports */

import {Component, Input, OnInit} from "@angular/core";
import {Review} from "../shared/interfaces/review";
import {Profile} from "../shared/interfaces/profile";



/* Component */

@Component({
	//selector required? refer to recArea-modal
	template: require("./profile.html")
})

export class ProfileComponent implements OnInit{
	@Input() profileId: string;
	review : Review[];
	profile: Profile;


}