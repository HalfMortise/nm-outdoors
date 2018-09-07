/******************************************************************************************************/
/*	Module name: profile.component.ts																							*/
/* Module description: Behind-the-curtain components populating the front-end of the user's profile		*/
/*	Author: HalfMortise																											*/
/*	Date: 9/7/2018																													*/
/******************************************************************************************************/

/* Imports */

import {Component, Input, OnInit} from "@angular/core";
import {Profile} from "../shared/interfaces/profile";
import {ProfileService} from "../shared/services/profile.service";
import {ActivatedRoute} from "@angular/router";
import {JwtHelperService} from "@auth0/angular-jwt";
import {Status} from "../shared/interfaces/status";



/* Component */

@Component({
	template:`
	<h1>{{profile.profileAtHandle}}</h1>
	
	`
})
export class ProfileComponent implements OnInit{

	profile: Profile;
	status: Status;

	constructor(private profileService: ProfileService, private jwtHelper : JwtHelperService) {}

	ngOnInit(): void {
		this.currentlySignedIn()
	}

	currentlySignedIn() : void {

		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));

		this.profileService.getProfileByProfileId(decodedJwt.auth.profileId)
			.subscribe(profile => this.profile = profile);

//		this.profileService.editProfile(this.http.put<Status>(this.profileUrl + profile.profileId, profile)) . subscribe(profile => this.profile = profile);

//		this.profileService.deleteProfile(this.http.delete<Status>(this.profileUrl + profile.profileId, profile)) . subscribe(profile => this.profile = profile);
	}


}