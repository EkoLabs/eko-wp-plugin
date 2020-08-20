# eko-wp-plugin

A Worpdress Plugin to embed and manage [eko](https://eko.com) interactive videos seamlessly into your Wordpress site.

## Installation

You can install the plugin into your Wordpress site in one of the following ways:

1. Install directly from wordpress plugin repository:
   - In wp dashboard, go to Plugins > Add New
   - Search for "eko-video"
   - click on "install Now", wp will than install the plugin to your site
   - Once installed, click on "Activate"
2. From this repository:
   - Download zip of this code directly from GitHub
   - Copy the content of the folder into _<path_to_local_wp_installtion>/wp-content/plugins_
   - In the plugin directory, run `npm run build`
   - In your wp dashboard, go to Plugins > Installed Plugins, locate "eko-video" and click on "activate"

### Installing the sample theme

The plugin is provided with a sample wp-theme to direct you into embedding eko videos, to use it:

1. Copy the theme folder inside the plugin's files into _<path_to_local_wp_installtion>/wp-content/themes_
2. In your wp dashboard, go to Appearance > Themes, locate "eko sample theme" and click on "activate"

# Usage

The plugin presents several methods for you to control and embed your interactive videos. It utilizes the powers of the [eko-js-sdk](https://www.npmjs.com/package/eko-js-sdk). We recommend reading and understanding it's usage first.

## Create eko-Video post

The plugin creates a new post type: `eko-video`, that holds all needed information for embedding your eko content.

1. Go to eko-Videos > Add New eko Video
2. Enter the id of your eko video, the information will be fetched automatically from our servers
3. For password protected videos, enter the password into the right input and update
4. You can preview the content and view the video's metadata directly from the edit page
5. You can view the new post itself, the template is loaded from the provided sample theme

### Advanced usage

To modify the way you eko-video posts are being displayed, create custom templates in your theme.

**Example:** Create _single-eko-video.php_ in your theme to change the way single eko-video pages are being displayed

## Direct Embedding of your videos

There are two ways embed your eko interactive videos in any kind of post:

1. Add a new block > Embed, enter your video's URL. Wp will automatically embed the video.
2. Use `eko-video` shortcode

## eko-video shortcode

Anywhere in your post, type `[eko-video id=<video id>]`

### Basic parameters

|    Param    |   Type    | Description                                                                                                |
| :---------: | :-------: | :--------------------------------------------------------------------------------------------------------- |
|     id      | `String`  | The id of the video to embed. **required**                                                                 |
| responsive  | `Boolean` | Control whether or not the embedded video will be responsive. Default: **true**                            |
|   height    | `String`  | css dimension for the embedded video height, if responsive will set the video's max-height                 |
|    width    | `String`  | css dimension for the embedded video width, if responsive will set the video's max-width                   |
|  password   | `String`  | To play password protected videos                                                                          |
| full_screen | `Boolean` | to embed the video over the entire viewport. will not work if custom dimensions are set. Default: **true** |

#### Example

```php
[eko-video id=MebL1z height=310px width=550px responsive=false]
```

### Advanced parameters

|      Param       |        Type        | Description                                                                         |
| :--------------: | :----------------: | :---------------------------------------------------------------------------------- |
|     autoplay     |     `Boolean`      | Default: **true**                                                                   |
|   query_params   |      `String`      | Comma separated list of query params to be forwarded to the player from the URL     |
|     revision     | `String`, `number` | To play a revision version of the video. Can be a revision number or 'latest'       |
|      debug       |     `Boolean`      | To present debug information on top of the video. Default: **false**                |
| clearCheckpoint  |     `Boolean`      | Prevent the player from saving in-video progression. Default: **true**              |
| hidePauseOverlay |     `Boolean`      | Prevent the player showing default overlay when video is paused. Default: **false** |
|    headnodeid    |      `String`      | Customize the video's headnode                                                      |
|      cover       |      `String`      | css identifier to override eko's custom cover when the video is being loaded        |

## API

The plugin provides a set of methods for WP developers to access the data and embed eko-video type posts

### Methods

### eko_is_video( \$post_id )

Returns `true` if the post is of type eko-video. if \$post_id not provided, the default is the current post in the loop

#### eko_the_field( $field_name, $post_id )

Prints the value of the post's field to the screen

|    Param     |   Type   | Description                                                               |
| :----------: | :------: | :------------------------------------------------------------------------ |
| \$field_name | `String` | The name of the desired field.                                            |
|  \$post_id   | `String` | The id of the post. **optional**, default is the current post in the loop |

#### eko_get_field( $field_name, $post_id )

Same as above, only difference is that the value is being returned and not printed to the screen

#### eko_get_field( $fields, $post_id )

Returns array(keys/values) of post's fields

|    Param     |   Type   | Description                                                               |
| :----------: | :------: | :------------------------------------------------------------------------ |
| \$field_name | `array`  | The names of the desired fields.                                          |
|  \$post_id   | `String` | The id of the post. **optional**, default is the current post in the loop |

#### eko_get_all_fields_formatted( \$post_id )

Same as above, returns array(keys/values) of all of the posts fields

Available fields:

- video_id
- password
- title
- thumbnail (url of the video's thumbnail)
- canonical_url
- duration (estimated, in seconds)
- kids_content (whether or not this video should comply to [COPPA regulations](https://www.ftc.gov/enforcement/rules/rulemaking-regulatory-reform-proceedings/childrens-online-privacy-protection-rule))
- orientation (represents the video's layout - vertical/horizontal)

### Embedding API

#### eko_embed_video_by_id( $videoId, $config, $containerId, $events )

Embeds an eko video

|     Param     |   Type   | Description                                                                                                                |
| :-----------: | :------: | :------------------------------------------------------------------------------------------------------------------------- |
|   \$videoId   | `String` | Id for the embedded video. **required**                                                                                    |
|   \$config    | `array`  | Configure the way the video is displayed. **optional** \*                                                                  |
| \$containerId | `String` | Id for container div for the embed iframe. **optional**, by default will create a new div with id _container-\<videoId\>_  |
|   \$events    | `array`  | List of events to be forwarded to the player . **optional**, defaults are ['nodestart', 'nodeend', 'playing', 'pause']\*\* |

##### \* List of all available parameters for the \$config array:

|      Param       |        Type        | Description                                                                                          |
| :--------------: | :----------------: | :--------------------------------------------------------------------------------------------------- |
|    responsive    |     `Boolean`      | Control whether or not the embedded video will be responsive. Default: **true**                      |
|      height      |      `String`      | css dimension for the embedded video height, if responsive will set the video's max-height           |
|      width       |      `String`      | css dimension for the embedded video width, if responsive will set the video's max-width             |
|     password     |      `String`      | To play password protected videos                                                                    |
|     autoplay     |     `Boolean`      | Default: **true**                                                                                    |
|   query_params   |      `array`       | List of query params to be forwarded to the player from the URL                                      |
|       env        |      `String`      | Dev environment to play the video from, Default is empty. **It is not advised to change that field** |
|     revision     | `String`, `number` | To play a revision version of the video. Can be a revision number or 'latest'                        |
|      debug       |     `Boolean`      | To present debug information on top of the video. Default: **false**                                 |
| clearCheckpoint  |     `Boolean`      | Prevent the player from saving in-video progression. Default: **true**                               |
| hidePauseOverlay |     `Boolean`      | Prevent the player showing default overlay when video is paused. Default: **false**                  |
|    headnodeid    |      `String`      | Customize the video's headnode                                                                       |
|      cover       |      `String`      | css identifier to override eko's custom cover when the video is being loaded                         |

##### \*\* more explanation about events can be found in [eko developer site](https://developer.eko.com/docs/embedding/dev.html#Core-Events)

#### eko_embed_current_video( $config, $containerId, \$events )

Same as above method with the only exception of \$videoId being derived from current post in the loop.

#### eko_embed_fixed_size( $videoId, $height, $width, $config, $containerId, $events )

Same as `eko_embed_video_by_id`.
`$height` and `$width` are explicitly being changed. Embedded video is not responsive by default.

#### eko_embed_current_fixed_size( $height, $width, $config, $containerId, \$events )

Same as above method with the only exception of \$videoId being derived from current post in the loop.

## eko Options

The plugin creates another menu page in the admin dashboard in which you can control the following:

1. API env - the environment from which all of the videos will be played from. It is advised to leave the API env input empty, unless you specifically need to test different environments.
2. Slug for eko Video post type - by default, the eko-video post type's slug is `eko-videos`. You are given the ability to modify that here.
