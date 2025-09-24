import * as React from "react"
import { cva, type VariantProps } from "class-variance-authority"

import { cn } from '@/lib/utils'

const badgeVariants = cva(
  "inline-flex items-center rounded-radius border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-[color:var(--color-ring)] focus:ring-offset-2",
  {
    variants: {
      variant: {
        default:
          "border-transparent bg-[color:var(--color-primary)] text-white shadow hover:opacity-90",
        secondary:
          "border-transparent bg-[color:var(--color-neutral-100)] text-[color:var(--color-text)] hover:bg-[color:var(--color-neutral-200)] dark:bg-[color:var(--color-neutral-800)] dark:hover:bg-[color:var(--color-neutral-700)]",
        destructive:
          "border-transparent bg-[color:var(--color-danger)] text-[color:var(--color-danger-foreground)] shadow hover:opacity-90",
        outline: "text-[color:var(--color-text)] border-[color:var(--color-border)]",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  }
)

export interface BadgeProps
  extends React.HTMLAttributes<HTMLDivElement>,
    VariantProps<typeof badgeVariants> {}

function Badge({ className, variant, ...props }: BadgeProps) {
  return (
    <div className={cn(badgeVariants({ variant }), className)} {...props} />
  )
}

export { Badge, badgeVariants }
