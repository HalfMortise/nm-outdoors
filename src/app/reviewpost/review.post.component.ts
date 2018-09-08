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
	template: require("./reviewpost.html"),
	selector: "review-post"

})

export class ReviewPostComponent implements OnInit{
	reviews: Review[] = [];
	recAreaId = this.route.snapshot.params["recAreaId"];
	recArea: RecArea;
	status: Status;


	constructor(protected reviewService: ReviewService, protected recAreaService: RecAreaService, protected route: ActivatedRoute, protected formBuilder: FormBuilder){



	}
	ngOnInit(){
		this.recAreaService.getRecAreaByRecAreaId(this.recAreaId).subscribe(recArea => this.recArea = recArea);
		this.createAreaForm = this.formBuilder.group({
			reviewText: ["",[Validators.maxLength(512), Validators.required]]
		} );
   this.loadReviews();
	}

	loadReviews(): any {
		this.reviewService.getReviewbyRecAreaId(this.recAreaId).subscribe(reviews => this.reviews = reviews);

	}

}
