<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int $affiliate_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateProduct whereAffiliateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateProduct whereUpdatedAt($value)
 */
	class AffiliateProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $affiliate_id
 * @property string $invoiceID
 * @property int $amount
 * @property string|null $payment_method
 * @property string|null $payment_type
 * @property string|null $payment_details
 * @property int $status 0=pending,1=approved,2=declined
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw whereAffiliateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AffiliateWithdraw whereUpdatedAt($value)
 */
	class AffiliateWithdraw extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $image
 * @property string|null $text
 * @property string|null $type normal,offer
 * @property string|null $title_1
 * @property string|null $title_2
 * @property string|null $title_3
 * @property string|null $btn_name
 * @property string|null $btn_link
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereBtnLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereBtnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereTitle1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereTitle2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereTitle3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereUpdatedAt($value)
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $site_name
 * @property string|null $dark_logo
 * @property string|null $light_logo
 * @property string|null $phone_1
 * @property string|null $phone_2
 * @property string|null $mail
 * @property string|null $address
 * @property string|null $fav_icon
 * @property string|null $fb_link
 * @property string|null $insta_link
 * @property string|null $twitter_link
 * @property string|null $youtube_link
 * @property string|null $vimeo_link
 * @property string|null $linkedin_link
 * @property string|null $skype_link
 * @property string|null $about_text
 * @property string|null $opening_hours_text
 * @property string|null $copyright_text
 * @property string|null $product_sku_prefix
 * @property string|null $newsletter_bgImage
 * @property string|null $order_invoice_prefix
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $google_schema
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereAboutText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereCopyrightText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereDarkLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereFavIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereFbLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereGoogleSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereInstaLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereLightLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereLinkedinLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereNewsletterBgImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereOpeningHoursText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereOrderInvoicePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo wherePhone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereProductSkuPrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereSiteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereSkypeLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereTwitterLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereVimeoLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BasicInfo whereYoutubeLink($value)
 */
	class BasicInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $short_description
 * @property string|null $long_description
 * @property string|null $image
 * @property string|null $author
 * @property string $author_image
 * @property string $published_date
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $google_schema
 * @property int $status 1=active, 0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereAuthorImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereGoogleSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereLongDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog wherePublishedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereUpdatedAt($value)
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $google_schema
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereGoogleSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereUpdatedAt($value)
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $ip
 * @property int $product_id
 * @property int|null $variant_id
 * @property int|null $color_id
 * @property int $quantity
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Productcolor|null $productcolor
 * @property-read \App\Models\Productvariant|null $productvariant
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart whereVariantId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property string $SKU_prefix
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $google_schema
 * @property int $front_status 1=active,0=inactive
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subcategory> $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereFrontStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereGoogleSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSKUPrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $subcategory_id
 * @property string|null $image
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $google_schema
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subcategory $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereGoogleSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChildCategory whereUpdatedAt($value)
 */
	class ChildCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $code
 * @property string|null $description
 * @property string|null $image
 * @property int $status 1=active, 0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Color whereUpdatedAt($value)
 */
	class Color extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $type percentage,flat
 * @property int|null $discount
 * @property string $active_date
 * @property string $expire_date
 * @property int $status 1=active, 0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereActiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coupon whereUpdatedAt($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $type
 * @property string|null $api_key
 * @property string|null $secret_key
 * @property string|null $url
 * @property string|null $token
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Courier whereUrl($value)
 */
	class Courier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string $phone
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $banner
 * @property string|null $banner_title
 * @property string|null $video
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string|null $review
 * @property int $product_id
 * @property string|null $image_one
 * @property string|null $image_two
 * @property string|null $image_three
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereBannerTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereImageOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereImageThree($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereImageTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LandingPage whereVideo($value)
 */
	class LandingPage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $invoiceID
 * @property string|null $entry_complete
 * @property string|null $web_id
 * @property string|null $user_id
 * @property int|null $customer_id
 * @property string|null $order_status_id
 * @property string|null $payment
 * @property string|null $customer_note
 * @property string|null $memo
 * @property string|null $payment_method
 * @property int|null $payment_type_id
 * @property string|null $payment_id
 * @property string|null $paymentAgentNumber
 * @property int|null $courier_id
 * @property int $subtotal
 * @property int $total
 * @property string|null $area_name
 * @property int|null $delivery_charge
 * @property int|null $discount_charge
 * @property int|null $shipping_charge_id
 * @property int|null $payment_amount
 * @property string $order_date
 * @property string|null $delivery_date
 * @property string|null $complete_date
 * @property string|null $last_updated
 * @property int|null $affiliate_id
 * @property int|null $admin_id
 * @property int|null $store_id
 * @property string|null $consignmentID
 * @property string|null $trackingID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $admin
 * @property-read \App\Models\Courier|null $courier
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderProduct> $orderProducts
 * @property-read int|null $order_products_count
 * @property-read \App\Models\OrderStatus|null $orderStatus
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAffiliateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCompleteDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereConsignmentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCourierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDiscountCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereEntryComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereLastUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentAgentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingChargeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTrackingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereWebId($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int|null $productvariant_id
 * @property string|null $product_SKU
 * @property string $product_name
 * @property string|null $color
 * @property string|null $variant
 * @property int $product_price
 * @property float $discount
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereProductSKU($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereProductvariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereVariant($value)
 */
	class OrderProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $status_name
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereStatusName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderStatus whereUpdatedAt($value)
 */
	class OrderStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property string|null $custom_css
 * @property string|null $custom_js
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $google_schema
 * @property int $type
 * @property int $status 1=active, 0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereCustomCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereCustomJs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereGoogleSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereUpdatedAt($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $type
 * @property string|null $app_key
 * @property string|null $app_secret
 * @property string|null $username
 * @property string|null $password
 * @property string|null $store_id
 * @property string|null $store_password
 * @property string|null $base_url
 * @property string|null $success_url
 * @property string|null $return_url
 * @property string|null $prefix
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereAppKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereAppSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereBaseUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereReturnUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereStorePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereSuccessUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentGateway whereUsername($value)
 */
	class PaymentGateway extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $pixel_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pixel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pixel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pixel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pixel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pixel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pixel wherePixelCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pixel whereUpdatedAt($value)
 */
	class Pixel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $category_id
 * @property int|null $brand_id
 * @property int|null $subcategory_id
 * @property int|null $childcategory_id
 * @property int|null $product_type_id
 * @property string $name
 * @property string $slug
 * @property string|null $short_description
 * @property string|null $long_description
 * @property string|null $thumbnail_img
 * @property string $affiliate_commission
 * @property string|null $SKU
 * @property string|null $shipping_return_text
 * @property string|null $additional_info_text
 * @property string|null $youtube_link
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $google_schema
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\ChildCategory|null $childcategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderProduct> $orderProducts
 * @property-read int|null $order_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Productcolor> $productcolors
 * @property-read int|null $productcolors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Productvariant> $productvariants
 * @property-read int|null $productvariants_count
 * @property-read \App\Models\Subcategory|null $subcategory
 * @property-read \App\Models\ProductType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereAdditionalInfoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereAffiliateCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereChildcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereGoogleSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLongDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSKU($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereShippingReturnText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereThumbnailImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereYoutubeLink($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property int $status 1=active, 0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereUpdatedAt($value)
 */
	class ProductType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $color_id
 * @property int $product_id
 * @property string $color_name
 * @property string $image
 * @property string|null $images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Color $color
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor whereColorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productcolor whereUpdatedAt($value)
 */
	class Productcolor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $variant_id
 * @property int $product_id
 * @property int|null $productcolor_id
 * @property string|null $variant_name
 * @property string $regular_price
 * @property string $sale_price
 * @property int $total_stock
 * @property int $available_stock
 * @property int $sold_stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Productcolor|null $productcolor
 * @property-read \App\Models\PurchaseProduct|null $purchaseProduct
 * @property-read \App\Models\Variant $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereAvailableStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereProductcolorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereRegularPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereSoldStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereTotalStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Productvariant whereVariantName($value)
 */
	class Productvariant extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $invoiceID
 * @property string $date
 * @property int $supplier_id
 * @property string $total_amount
 * @property string $paid_amount
 * @property string $due_amount
 * @property int $delivery_charge
 * @property int|null $admin_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $products
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseProduct> $purchaseProducts
 * @property-read int|null $purchase_products_count
 * @property-read \App\Models\Supplier $suppliers
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereDeliveryCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereDueAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase whereUpdatedAt($value)
 */
	class Purchase extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $purchase_id
 * @property int $product_id
 * @property int $productvariant_id
 * @property string $product_name
 * @property int $product_quantity
 * @property string $product_SKU
 * @property string $product_variant
 * @property string $product_price
 * @property string $total
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereProductQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereProductSKU($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereProductVariant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereProductvariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseProduct whereUpdatedAt($value)
 */
	class PurchaseProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $area_name
 * @property int $delivery_charge
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge whereAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge whereDeliveryCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingCharge whereUpdatedAt($value)
 */
	class ShippingCharge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $image
 * @property string|null $link
 * @property string|null $title
 * @property string|null $text
 * @property string|null $btn_name
 * @property string|null $btn_link
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereBtnLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereBtnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slider whereUpdatedAt($value)
 */
	class Slider extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string|null $url
 * @property string|null $api_key
 * @property string|null $senderID
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway whereSenderID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SmsGateway whereUrl($value)
 */
	class SmsGateway extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock query()
 */
	class Stock extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $category_id
 * @property string|null $image
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $google_schema
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChildCategory> $childCategories
 * @property-read int|null $child_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereGoogleSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subcategory whereUpdatedAt($value)
 */
	class Subcategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $email
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUpdatedAt($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string $email
 * @property string|null $address
 * @property string|null $profile_image
 * @property string|null $company_name
 * @property string $total_amount
 * @property string $paid_amount
 * @property string $due_amount
 * @property string $partial_amount
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Purchase> $purchases
 * @property-read int|null $purchases_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDueAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePartialAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $supplier_id
 * @property int $purchase_id
 * @property string $amount
 * @property string|null $trx_id
 * @property string $date
 * @property int|null $admin_id
 * @property string $payment_type
 * @property string|null $comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereUpdatedAt($value)
 */
	class SupplierPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $gtm_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereGtmCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string $email
 * @property string|null $phone
 * @property string|null $dob
 * @property string|null $address
 * @property string|null $profile_image
 * @property string $account_balance
 * @property string $withdrawal_balance
 * @property string $purchase_balance
 * @property int|null $ref_code
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAccountBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePurchaseBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRefCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereWithdrawalBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $image
 * @property int $status 1=active, 0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Variant whereUpdatedAt($value)
 */
	class Variant extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $wcustomerName
 * @property string $wcustomerPhone
 * @property string|null $wcustomerEmail
 * @property string|null $wcustomerAddress
 * @property string|null $wcustomerProfile
 * @property string|null $wcustomerCompanyName
 * @property float $wcustomerTotalAmount
 * @property float $wcustomerPaidAmount
 * @property float $wcustomerDueAmount
 * @property float $wcustomerPartialAmount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wsale> $wsales
 * @property-read int|null $wsales_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerDueAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerPaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerPartialAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomer whereWcustomerTotalAmount($value)
 */
	class Wcustomer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $wcustomer_id
 * @property int|null $amount
 * @property string|null $trx_id
 * @property string $date
 * @property int $admin_id
 * @property int|null $payment_type_id
 * @property string $comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wcustomercomment whereWcustomerId($value)
 */
	class Wcustomercomment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $ip
 * @property int $product_id
 * @property string $product_name
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wishlist whereUserId($value)
 */
	class Wishlist extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $wcustomer_id
 * @property int $wsale_id
 * @property int|null $amount
 * @property string|null $trx_id
 * @property string $date
 * @property int $admin_id
 * @property string|null $payment_type
 * @property int|null $payment_id
 * @property string|null $comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Wsale $wsale
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereWcustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wpayment whereWsaleId($value)
 */
	class Wpayment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $invoiceID
 * @property string $date
 * @property int $wcustomer_id
 * @property float $totalAmount
 * @property float $paid
 * @property float $due
 * @property int $deliveryCharge
 * @property string $status
 * @property int $admin_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $products
 * @property-read \App\Models\Wcustomer $wcustomers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wsaleproduct> $wsaleproducts
 * @property-read int|null $wsaleproducts_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereDeliveryCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsale whereWcustomerId($value)
 */
	class Wsale extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $wsale_id
 * @property int $product_id
 * @property string|null $product_code
 * @property string|null $product_name
 * @property int|null $size_id
 * @property string|null $size
 * @property float $product_price
 * @property int $quantity
 * @property float $total
 * @property int $status 1=active,0=inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Wsale $wsales
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsaleproduct whereWsaleId($value)
 */
	class Wsaleproduct extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $wsale_product_id
 * @property int $product_id
 * @property string|null $product_name
 * @property int|null $size_id
 * @property string|null $size
 * @property int $wsale
 * @property int $stock
 * @property int $initial_stock
 * @property int $total_stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereInitialStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereTotalStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereWsale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsalestock whereWsaleProductId($value)
 */
	class Wsalestock extends \Eloquent {}
}

