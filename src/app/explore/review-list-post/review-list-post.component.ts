import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../../shared/services/rec.area.service";
import {ActivatedRoute, Route, Router} from "@angular/router";
import {RecArea} from "../../shared/interfaces/rec.area";
import {Review} from "../../shared/interfaces/review";
import {ReviewService} from "../../shared/services/review.service";
import {ProfileService} from "../../shared/services/profile.service";
import {Profile} from "../../shared/interfaces/profile";
import {Status} from "../../shared/interfaces/status";


@Component({
	template: require("./review-list-post.html"),
	selector: "reviews-list",
})

export class ReviewListPostComponent implements OnInit {
	review: Review = {reviewId: null, reviewProfileId: null, reviewRecAreaId: null, reviewContent: null, reviewDateTime: null, reviewRating: null};
	reviews: Review[] = [];
	recAreaId = this.route.snapshot.params["recAreaId"];
	recArea: RecArea = {recAreaId : null, recAreaDescription : null, recAreaDirections : null, recAreaImageUrl : null, recAreaLat : null, recAreaLong : null, recAreaMapUrl : null, recAreaName : null};
	profile: Profile;
	tempReviews: any[];
	status: Status;




	constructor(
		protected recAreaService: RecAreaService,
		protected reviewService: ReviewService,
		protected route: ActivatedRoute,
		protected profileService: ProfileService
	) {
	}

	ngOnInit() {
		this.recAreaService.getRecAreaByRecAreaId(this.recAreaId).subscribe(reply => this.recArea = reply);
		this.loadReviews();
	}

	loadReviews(): any {
		if(this.recAreaId !== undefined) {
			this.reviewService.getReviewByRecAreaId(this.recAreaId).subscribe(reviews => this.tempReviews = reviews);
		}
	}
}