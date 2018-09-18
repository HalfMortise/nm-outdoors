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
import {ReviewProfile} from "../shared/interfaces/review-profile";
import {FileUploader} from "ng2-file-upload";
import {Cookie} from "ng2-cookies";

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
	};
	profileId : string;
	recArea: RecArea;
	review: Review;
	reviews : ReviewProfile[] = [];
	status: Status;
	uploader: FileUploader = new FileUploader({
		itemAlias: "image",
		url: "./api/profile-image/",
		headers: [
			{name: "X-JWT-TOKEN", value: window.localStorage.getItem("jwt-token")},
			{name: "X-XSRF-TOKEN", value: Cookie.get("XSRF-TOKEN")},
		],
		additionalParameter: {}
	});


	constructor(
		private profileService: ProfileService,
		private recAreaService: RecAreaService,
		private reviewService: ReviewService,
		private jwtHelper: JwtHelperService,
		private authService: AuthService,
		protected route: ActivatedRoute
	) {}

	ngOnInit(): void {
		this.currentUser();
		this.getReviewsByProfileId();
	}


	currentUser(): void {

		let isLoggedIn: boolean = this.authService.loggedIn();
		// console.log(isLoggedIn);
		if(isLoggedIn) {
		this.profileId = this.authService.decodeJwt().auth.profileId;
		this.profileService.getProfileByProfileId(this.profileId).subscribe(reply => this.profile = reply);
		}
	}

	getReviewsByProfileId() {
		this.reviewService.getReviewbyProfileId(this.profileId).subscribe(reply => this.reviews = reply);
	}

	uploadImage(): void {
		this.uploader.uploadAll();
		this.uploader.onSuccessItem = () => {
			console.log("Image successfully uploaded");
		}
	}
}
