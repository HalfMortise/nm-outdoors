/* imports*/

import {Component, Input, OnInit} from "@angular/core";
import {ReviewService} from "../shared/services/review.service";
import {Review} from "../shared/interfaces/review";
import {Observable} from "rxjs";
import {RecAreaService} from "../shared/services/rec.area.service";
import {RecArea} from "../shared/interfaces/rec.area";
import {ActivatedRoute, Params} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../shared/interfaces/status";


/*component*/

@Component({
	template: require("./review-post.template.html"),
	selector: "review-post"

})

export class ReviewPostComponent implements OnInit{
	reviews: any[];
	recAreaId = this.route.snapshot.params["recAreaId"];
	recArea: RecArea = {recAreaId : "", recAreaDescription : "", recAreaDirections : "", recAreaImageUrl : "", recAreaLat : "", recAreaLong : "", recAreaMapUrl : "", recAreaName : ""};
	status: Status;
	review: Review;
	reviewForm: FormGroup;


	constructor(protected reviewService: ReviewService, protected recAreaService: RecAreaService, protected route: ActivatedRoute, protected formBuilder: FormBuilder){



	}
	ngOnInit(){
		if(this.recAreaId !== undefined) {
      this.recAreaService.getRecAreaByRecAreaId(this.recAreaId).subscribe(reply => this.recArea = reply);
      this.reviewForm = this.formBuilder.group({
        reviewText: ["", [Validators.maxLength(512), Validators.required]]
      });
      this.loadReviews();
    }
	}

	loadReviews(): any {
		if(this.recAreaId !== undefined) {
     	 this.reviewService.getReviewByRecAreaId(this.recAreaId).subscribe(reviews => this.reviews = reviews);
    }
	}

	//recArea review form that exists in review-post.template.html
    recAreaReviewForm(): any {
		let review: Review = {
			reviewId: null,
			reviewProfileId: null,
			reviewRecAreaId: this.recAreaId,
			reviewContent: this.reviewForm.value.reviewText,
			reviewDateTime : null,
			reviewRating: null
		};
		 this.reviewService.createReview(review).subscribe(status => this.status = status);
		  if(this.status.status === 200){
		  	this.loadReviews();
		  }
	 }
}
