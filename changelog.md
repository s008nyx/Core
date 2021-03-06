# Changelog
## 1.0.0
- First public release.

## 1.0.1
- Deleted mention for file `Repository/User.php` from `hashes.json`
- Updated link to support in the admin panel. Now it leads to the resource page on XenForo.Info.

## 1.0.2
- The code associated with the DB on the page `Connected Accounts` is now optimized.

## 1.0.3
- Added Telegram Post Widget.
- Added Notifications.
- Added style settings for login button.

## 1.0.3.1
- Fixed `upgrade()` in `Setup.php`

## 1.0.4
- Added AddOn settings in options.
  - Added flood protect.
  - Added global notifications enabler.
- Removed accidentally left debug code line.

# 1.0.5
- Small refactor.
- Added permission (see issue #2) for configuring notifications availability.
- Fixed error when any conversation action creates a error `TypeError`

# 1.0.5.1
- Added forgotten changes in `Utils` class.

# 1.0.5.2
- Added forgotten changes in `Notifier` class (notifications for Conversations).

# 1.0.6
- Added proxy support.
- Now notifications adds in queue, and handles by Cron Job.

# 1.0.6.1
- Added a new method `editMessage` in `Kruzya\Telegram\Entity\User` entity.
- Fixed a bug when message sender in conversation receives notification too.

# 1.0.7
- Removed a notifications.
  Now notifications placed [in separate addon](https://github.com/XF-Telegram/Notifications).
- Removed a Post BB-Media code.
  Now post BB-Media code placed [in separate addon](https://github.com/XF-Telegram/MediaPost).
- Implemented new API class.

# 1.0.7.1
- Small template changes.
