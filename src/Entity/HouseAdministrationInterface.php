<?php

namespace Drupal\house_administration\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * House administration Interface.
 *
 * @ingroup house_administration
 */
interface HouseAdministrationInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
