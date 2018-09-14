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
import {AuthService} from "../shared/services/auth.service";
import {Review} from "../shared/interfaces/review";
import {ReviewService} from "../shared/services/review.service";
import {RecAreaService} from "../shared/services/rec.area.service";
import {RecArea} from "../shared/interfaces/rec.area";

/* Component */

@Component({
	template: require("./profile.template.html")
})
export class ProfileComponent implements OnInit {

	profile: Profile = {
		profileId: "",
		profileActivationToken: "",
		profileAtHandle: "",
		profileEmail: "",
		profileHash: "",
		profileImageUrl: ""
	};

	// profiles: Profile[] = [];

	detailedReview: Review = {
		reviewId: "",
		reviewProfileId: "",
		reviewRecAreaId: "",
		reviewContent: "",
		reviewDateTime: "",
		reviewRating: null,
		profileAtHandle: null,
		profileImageUrl: null
	};

	recArea: RecArea;
	review: Review;
	reviews: Review[] = [];
	status: Status;


	constructor(
		private profileService: ProfileService,
		private recAreaService: RecAreaService,
		private reviewService: ReviewService,
		private jwtHelper: JwtHelperService,
		private authService: AuthService,
		protected route: ActivatedRoute
	) {}

	ngOnInit(): void {
		this.currentUser()
	}

	profileId = this.route.snapshot.params["profileId"];

	reviewId = this.route.snapshot.params["reviewId"];

	currentUser(): void {

		let isLoggedIn: boolean = this.authService.loggedIn();

		console.log(isLoggedIn);

		if(isLoggedIn) {}

		let profileId = this.authService.decodeJwt().auth.profileId;

		this.profileService.getProfileByProfileId(profileId).subscribe(reply => this.profile = reply);

	}
}