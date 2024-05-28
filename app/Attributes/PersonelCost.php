<?php

namespace App\Attributes;

use Attribute;
use App\Attributes\AttributeProperty;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class PersonelCost extends AttributeProperty {}
